package com.mysisal.sisal;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.Volley;

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
                Log.d("response_userData", userData.toString());

            }
        }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError response) {

            }
        });
        queue.add(jsObjRequest);
    }
}
