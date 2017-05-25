package com.mysisal.sisal;

import android.animation.Animator;
import android.animation.AnimatorListenerAdapter;
import android.annotation.TargetApi;
import android.app.AlarmManager;
import android.app.Notification;
import android.app.PendingIntent;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.graphics.Color;
import android.os.Handler;
import android.support.annotation.NonNull;
import android.support.design.widget.Snackbar;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
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

import org.apache.commons.io.IOUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import org.json.simple.parser.JSONParser;
import org.json.simple.parser.ParseException;

import java.io.BufferedReader;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.InputStreamReader;
import java.io.StringWriter;
import java.io.UnsupportedEncodingException;
import java.nio.charset.StandardCharsets;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
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
    JSONObject serverResponse;
    JSONObject userData;
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

        userData = new JSONObject();

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

        SharedPreferences settings = getApplicationContext().getSharedPreferences("settings", 0);
        if(!settings.getBoolean("saved", false))
        {
            SharedPreferences.Editor editor = settings.edit();
            editor.putBoolean("saved", true);
            editor.putInt("titleSize", 30);
            editor.putInt("textSize", 20);
            editor.putInt("barTextSize", 25);
            editor.putInt("menuOptionsTextSize", 30);
            editor.putInt("menuTitleTextSize", 40);
            editor.apply();
        }
    }


    @Override
    public void onBackPressed() {

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


                        try {
                            String key = serverResponse.getString("key");
                            String type = serverResponse.getString("type");

                            SharedPreferences settings = getApplicationContext().getSharedPreferences("userData", 0);
                            SharedPreferences.Editor editor = settings.edit();
                            editor.putString("key", key);
                            editor.putString("type", type);
                            editor.apply();
                            getData();

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


    private void getData()
    {
        Intent servicio = new Intent(getApplicationContext(), updateInfo.class);
        startService(servicio);

        SharedPreferences datos = getApplicationContext().getSharedPreferences("userData", 0);
        final String key = datos.getString("key", "");
        final String type = datos.getString("type", "");





        final ProgressDialog progress = new ProgressDialog(this);
        progress.setTitle("Obteniendo información");
        progress.setMessage("Espere un momento porfavor...");
        progress.show();

        Runnable progressRunnable = new Runnable() {

            @Override
            public void run() {
                progress.cancel();
                String datos2 ="{}";
                FileInputStream inputStream;
                try{
                    inputStream = openFileInput("data.json");
                    StringWriter writer = new StringWriter();
                    IOUtils.copy(inputStream, writer, "UTF8");
                    datos2 = writer.toString();
                    userData = new JSONObject(datos2);
                } catch(Exception e) {

                }
                if (userData.toString().equals("{}")) {
                    txtIndications.setText("Error, porfavor vuelva a intentarlo");
                    txtIndications.setTextColor(Color.RED);
                    SharedPreferences preferences = getSharedPreferences("userData", 0);
                    preferences.edit().remove("type").commit();
                    preferences.edit().remove("key").commit();

                    String type = preferences.getString("type", "");
                    String key = preferences.getString("key", "");
                } else {

                    String filename = "data.json";
                    FileOutputStream outputStream;

                    try {
                        outputStream = openFileOutput(filename, Context.MODE_PRIVATE);
                        outputStream.write(userData.toString().getBytes());
                        outputStream.close();
                    } catch (Exception e) {
                        e.printStackTrace();
                    }

                    if (type.equals("medicos")) {
                        Intent intent = new Intent(getApplicationContext(), newPinActivity.class);
                        startActivity(intent);
                    } else {

                        Alarms alarms = Alarms.getInstance(getApplicationContext());



                        Calendar now = Calendar.getInstance();
                        Intent update = new Intent(getApplicationContext(), updateInfo.class);
                        Integer cada = 24;
                        alarms.setIntentServiceAlarm(update, getApplicationContext(), now, cada, 1505);


                        Intent intent = new Intent(getApplicationContext(), patientStartActivity.class);
                        startActivity(intent);


                    }

                }
            }
        };

        Handler pdCanceller = new Handler();
        pdCanceller.postDelayed(progressRunnable, 3000);

    }

}

