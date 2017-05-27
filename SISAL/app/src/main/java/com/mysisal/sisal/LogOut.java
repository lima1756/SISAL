package com.mysisal.sisal;

import android.app.AlarmManager;
import android.app.PendingIntent;
import android.app.Service;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.IBinder;
import android.util.Log;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.Volley;

import org.apache.commons.io.IOUtils;
import org.json.JSONObject;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.StringWriter;
import java.util.HashMap;
import java.util.Map;

/**
 * Created by Luis Iván Morett on 07/05/2017.
 */

public class LogOut extends Service {

    private JSONObject userData;

    @Override
    public IBinder onBind(Intent intent) {
        // TODO: Return the communication channel to the service.
        return null;
    }

    @Override
    public void onCreate()
    {

        final Alarms alarms = Alarms.getInstance(getApplicationContext());

        if(!alarms.isEmpty())
            alarms.unSetAll(getApplicationContext());


        Integer id = 1505;
        Intent intentDelete = new Intent(getApplication(), updateInfo.class);




        PendingIntent pendingIntent = PendingIntent.getBroadcast(getApplication(), id, intentDelete, PendingIntent.FLAG_UPDATE_CURRENT);
        AlarmManager am = (AlarmManager) getSystemService(ALARM_SERVICE);
        pendingIntent.cancel();
        am.cancel(pendingIntent);


        SharedPreferences preferences = getSharedPreferences("userData", 0);
        preferences.edit().remove("type").commit();
        preferences.edit().remove("key").commit();

        SharedPreferences pinData = getSharedPreferences("pinData", 0);
        pinData.edit().remove("pin").commit();

        SharedPreferences settings = getSharedPreferences("settings", 0);
        pinData.edit().remove("notifications").commit();

        String type2 = preferences.getString("type", "");
        String key2 = preferences.getString("key", "");

        try {
            File file = getFileStreamPath("data.json");
            file.delete();
            file = getFileStreamPath("Alarms.data");
            file.delete();
        } catch (Exception e) {
            e.printStackTrace();
        }


        if(type2.equals("") && key2.equals("")) {
            Intent intent = new Intent(getApplication(), Login.class);
            intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
            startActivity(intent);
        }

        stopSelf();
    }
}
