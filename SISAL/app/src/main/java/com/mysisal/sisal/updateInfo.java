package com.mysisal.sisal;

import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.app.Service;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.os.IBinder;
import android.os.SystemClock;
import android.support.v4.app.NotificationCompat;
import android.util.Log;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.Volley;

import org.json.JSONObject;

import java.io.FileOutputStream;
import java.util.HashMap;
import java.util.Map;

public class updateInfo extends Service {

    JSONObject userData;

    public updateInfo() {
    }

    @Override
    public IBinder onBind(Intent intent) {
        // TODO: Return the communication channel to the service.
        return null;
    }

    @Override
    public void onCreate()
    {
        SharedPreferences datos = getApplicationContext().getSharedPreferences("userData", 0);
        final String key = datos.getString("key", "");
        final String type = datos.getString("type", "");


        Map<String, String> params = new HashMap<String, String>();
        params.put("key", key);
        params.put("type", type);

        RequestQueue queue = Volley.newRequestQueue(this);

        String url = "https://www.mysisal.com/android/retreiveData";


        CustomRequest jsObjRequest = new CustomRequest(Request.Method.POST, url, params, new Response.Listener<JSONObject>() {

            @Override
            public void onResponse(JSONObject response) {
                userData = response;
                    String filename = "data.json";
                    FileOutputStream outputStream;

                    try {
                        outputStream = openFileOutput(filename, Context.MODE_PRIVATE);
                        outputStream.write(userData.toString().getBytes());
                        outputStream.close();
                    } catch (Exception e) {

                    }
                Alarms alarms = Alarms.getInstance(getApplicationContext());
                if(!alarms.isEmpty())
                    alarms.unSetAll(getApplicationContext());
                alarms.setAll(getApplicationContext());
                stopSelf();
            }
        }, new Response.ErrorListener() {

            @Override
            public void onErrorResponse(VolleyError response) {
                Log.d("Response", "Error: "+ response.getMessage());
                userData = new JSONObject();
                String filename = "data.json";
                FileOutputStream outputStream;
                try {
                    outputStream = openFileOutput(filename, Context.MODE_PRIVATE);
                    outputStream.write(userData.toString().getBytes());
                    outputStream.close();
                } catch (Exception e) {

                }
                stopSelf();
            }
        });
        queue.add(jsObjRequest);







    }

    @Override
    public void onDestroy()
    {
    }
}
