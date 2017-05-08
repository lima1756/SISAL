package com.mysisal.sisal;

import android.animation.Animator;
import android.animation.AnimatorListenerAdapter;
import android.annotation.TargetApi;
import android.app.Notification;
import android.app.ProgressDialog;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.os.Handler;
import android.support.annotation.NonNull;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.app.LoaderManager.LoaderCallbacks;

import android.content.CursorLoader;
import android.content.Loader;
import android.database.Cursor;
import android.net.Uri;
import android.os.AsyncTask;

import android.os.Build;
import android.os.Bundle;
import android.provider.ContactsContract;
import android.text.TextUtils;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.inputmethod.EditorInfo;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.TextView;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;
import org.json.simple.parser.JSONParser;
import org.json.simple.parser.ParseException;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.nio.charset.StandardCharsets;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import static android.Manifest.permission.READ_CONTACTS;
import static java.nio.charset.StandardCharsets.*;

/**
 * A login screen that offers login via email/password.
 */
public class Login extends AppCompatActivity {
    Button btnIngresar;
    TextView txtUsuario, txtPass;
    ProgressBar charging;
    JSONObject serverResponse;
    TextView txtIndications;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        SharedPreferences datos = getApplicationContext().getSharedPreferences("userData", 0);
        String type = datos.getString("type", "");
        if(!type.equals(""))
        {
            if(type.equals("medicos")) {
                Intent intent = new Intent(getApplicationContext(), startMedic.class);
                startActivity(intent);
            }
            else
            {
                Intent intent = new Intent(getApplicationContext(), patientStartActivity.class);
                startActivity(intent);
            }
        }

        setContentView(R.layout.activity_login);
        txtUsuario = (EditText) findViewById(R.id.txtUser);
        txtPass = (EditText) findViewById(R.id.txtPass);
        btnIngresar = (Button) findViewById(R.id.btnSign);
        txtIndications = (TextView) findViewById(R.id.Indication);

        serverResponse = new JSONObject();
        btnIngresar.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View view) {
                enviarDatos();
            }
        });


    }

    public String enviarDatos()
    {
        final String usuario = txtUsuario.getText().toString();
        final String pass = txtPass.getText().toString();
        String cypherPass;
        JSONObject respuesta;

        try{
            MessageDigest digest = MessageDigest.getInstance("SHA-256");
            byte[] hash = digest.digest(pass.getBytes("UTF-8"));
            StringBuffer hexString = new StringBuffer();

            for (int i = 0; i < hash.length; i++) {
                String hex = Integer.toHexString(0xff & hash[i]);
                if(hex.length() == 1) hexString.append('0');
                hexString.append(hex);
            }
            cypherPass = hexString.toString();
        } catch(Exception ex){
            cypherPass = "";
            Log.d("Error en cifrado",ex.getMessage());
        }

        Map<String, String> params = new HashMap<String, String>();
        params.put("user", usuario);
        params.put("pass", cypherPass);

        RequestQueue queue = Volley.newRequestQueue(this);

        String url = "https://www.mysisal.com/android/logIn";


        CustomRequest jsObjRequest = new CustomRequest(Request.Method.POST, url, params, new Response.Listener<JSONObject>() {

            @Override
            public void onResponse(JSONObject response) {
                serverResponse = response;
            }
        }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError response) {
                serverResponse = new JSONObject();
            }
        });
        queue.add(jsObjRequest);


        final ProgressDialog progress = new ProgressDialog(this);
        progress.setTitle("Iniciando Sesión");
        progress.setMessage("Espere un momento porfavor...");
        progress.show();

        Runnable progressRunnable = new Runnable() {

            @Override
            public void run() {
                progress.cancel();
                if(serverResponse.toString().equals("{}"))
                {
                    txtIndications.setText("Error, porfavor vuelva a intentarlo");
                    txtIndications.setTextColor(Color.RED);
                }
                else
                {
                    if(serverResponse.has("error")){
                        String error = "";
                        try {
                             error = serverResponse.getString("error");
                        }
                        catch (JSONException e){

                        }
                        switch(error){
                            case "type":
                                txtIndications.setText("Intente con una cuenta correcta");
                                break;
                            case "data":
                                txtIndications.setText("Revise los datos ingresados");
                                break;
                            default:
                                txtIndications.setText("Porfavor vuelva a intentarlo");
                                break;
                        }
                        txtIndications.setTextColor(Color.RED);
                    }
                    else {


                        Log.d("Response_Prueba2", serverResponse.toString());
                        try {
                            String key = serverResponse.getString("key");
                            String type = serverResponse.getString("type");

                            SharedPreferences settings = getApplicationContext().getSharedPreferences("userData", 0);
                            SharedPreferences.Editor editor = settings.edit();
                            editor.putString("key", key);
                            editor.putString("type", type);
                            editor.apply();
                            if(type.equals("medicos")) {
                                Intent intent = new Intent(getApplicationContext(), startMedic.class);
                                startActivity(intent);
                            }
                            else
                            {
                                Intent intent = new Intent(getApplicationContext(), patientStartActivity.class);
                                startActivity(intent);
                            }

                            /*
                                Leer las sharedPreferences
                                SharedPreferences settings2 = getApplicationContext().getSharedPreferences("userData", 0);
                                String homeKey = settings2.getString("key", "");
                                String homeType = settings2.getString("type", "");

                                Log.d("Responsekey", homeKey);
                                Log.d("ResponseType", homeType);
                            */
                        }
                        catch(JSONException e)
                        {

                        }
                    }
                }
            }
        };

        Handler pdCanceller = new Handler();
        pdCanceller.postDelayed(progressRunnable, 3000);

        return "a";
    }



}

