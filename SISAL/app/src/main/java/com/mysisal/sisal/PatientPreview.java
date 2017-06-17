package com.mysisal.sisal;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.FileOutputStream;
import java.util.HashMap;
import java.util.Map;

public class PatientPreview extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Intent intent = getIntent();

        setContentView(R.layout.activity_patient_preview);


        final LinearLayout miLayOut = (LinearLayout)findViewById(R.id.container);

        SharedPreferences datos = getApplicationContext().getSharedPreferences("userData", 0);
        final String key = datos.getString("key", "");
        final String type = datos.getString("type", "");

        String id = intent.getStringExtra("id");

        Map<String, String> params = new HashMap<String, String>();
        params.put("key", key);
        params.put("type", type);
        params.put("id", id);

        RequestQueue queue = Volley.newRequestQueue(this);

        String url = "https://www.mysisal.com/android/userData";


        CustomRequest jsObjRequest = new CustomRequest(Request.Method.POST, url, params, new Response.Listener<JSONObject>() {

            @Override
            public void onResponse(JSONObject response) {
                JSONObject userData = response;
                TextView Titles[] = new TextView[5];
                TextView Contents[] = new TextView[5];
                Boolean error = false;
                Boolean empty = false;
                SharedPreferences settings = getApplicationContext().getSharedPreferences("settings", 0);
                Log.d("Response_patientPreview", userData.toString());
                try {
                    if (!userData.toString().equals("{}")) {
                        Log.d("Response_hayDatos", "OK");
                        Titles[0] = new TextView(getApplicationContext());
                        Titles[0].setText("Usuario: ");
                        Contents[0] = new TextView(getApplicationContext());
                        Contents[0].setText(userData.getString("usuario"));
                        Titles[1] = new TextView(getApplicationContext());
                        Titles[1].setText("Nombre: ");
                        Contents[1] = new TextView(getApplicationContext());
                        Contents[1].setText(userData.getString("nombre") + " " + userData.getString("apellidoPaterno") + " " + userData.getString("apellidoMaterno"));
                        Titles[2] = new TextView(getApplicationContext());
                        Titles[2].setText("Ultima enfermedad diagnosticada: ");
                        Contents[2] = new TextView(getApplicationContext());
                        Contents[2].setText(userData.getString("enfermedad"));
                        Titles[3] = new TextView(getApplicationContext());
                        Titles[3].setText("Estado de la misma: ");
                        Contents[3] = new TextView(getApplicationContext());
                        Contents[3].setText(userData.getString("estado"));
                        Titles[4] = new TextView(getApplicationContext());
                        Titles[4].setText("Notas de la misma: ");
                        Contents[4] = new TextView(getApplicationContext());
                        Contents[4].setText(userData.getString("notas"));
                    }
                    else
                    {
                        empty = true;
                    }
                } catch (JSONException e)
                {
                    error = true;
                }
                if(!error && !empty)
                {
                    for(Integer i = 0; i< 5; i++) {
                        final int val = i + 1025;
                        Titles[i].setId(val+2025);
                        Contents[i].setId(val);
                        Titles[i].setTextColor(Color.BLACK);
                        Contents[i].setTextColor(Color.BLACK);
                        Titles[i].setTextSize(settings.getInt("titleSize", 30));
                        Contents[i].setTextSize(settings.getInt("contentSize", 20));
                        miLayOut.addView(Titles[i]);
                        miLayOut.addView(Contents[i]);
                    }
                }
                else if(empty)
                {
                    Titles[0] = new TextView(getApplicationContext());
                    Titles[0].setTextColor(Color.BLACK);
                    Titles[0].setTextSize(settings.getInt("titleSize", 30));
                    Titles[0].setText("No existe información previa");
                    miLayOut.addView(Titles[0]);
                }
                else if(error)
                {
                    Titles[0] = new TextView(getApplicationContext());
                    Titles[0].setTextSize(settings.getInt("titleSize", 30));
                    Titles[0].setText("Error, porfavor vuelva a intentarlo");
                    Titles[0].setTextColor(Color.RED);
                    miLayOut.addView(Titles[0]);
                }

            }
        }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError response) {
                TextView Titles[] = new TextView[5];
                SharedPreferences settings = getApplicationContext().getSharedPreferences("settings", 0);
                Titles[0] = new TextView(getApplicationContext());
                Titles[0].setTextSize(settings.getInt("titleSize", 30));
                Titles[0].setText("Error, porfavor vuelva a intentarlo:\n " + response.getMessage());
                Titles[0].setTextColor(Color.RED);
                miLayOut.addView(Titles[0]);
            }
        });
        queue.add(jsObjRequest);
    }

    @Override
    public void onBackPressed() {
            Intent intent = new Intent(getApplicationContext(), doctorDates.class);
            intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
            startActivity(intent);
    }
}