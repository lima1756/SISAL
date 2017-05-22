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

import org.apache.commons.io.IOUtils;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.StringWriter;

/**
 * Created by Luis Iván Morett on 07/05/2017.
 */

public class LogOut extends Service {



    @Override
    public IBinder onBind(Intent intent) {
        // TODO: Return the communication channel to the service.
        return null;
    }

    @Override
    public void onCreate()
    {
        Toast toast = Toast.makeText(getApplication(), "Cerrando Sesion...", Toast.LENGTH_SHORT);
        toast.show();
        Alarms alarms = Alarms.getInstance(getApplication());
        if(!alarms.isEmpty())
            alarms.unSetAll(getApplication());

        Integer id = 1505;
        Intent intentDelete = new Intent(getApplication(), updateInfo.class);


        Boolean existIntent = PendingIntent.getBroadcast(getApplication(), id, intentDelete, 0) != null;
        Log.d("Response_pendingUpdates", existIntent.toString());



        Log.d("Response_id", id.toString());
        PendingIntent pendingIntent = PendingIntent.getBroadcast(getApplication(), id, intentDelete, PendingIntent.FLAG_UPDATE_CURRENT);
        AlarmManager am = (AlarmManager) getSystemService(ALARM_SERVICE);
        am.cancel(pendingIntent);
        pendingIntent.cancel();

        SharedPreferences preferences = getSharedPreferences("userData", 0);
        preferences.edit().remove("type").commit();
        preferences.edit().remove("key").commit();

        String type = preferences.getString("type", "");
        String key = preferences.getString("key", "");

        try {
            File file = getFileStreamPath("data.json");
            file.delete();
            file = getFileStreamPath("Alarms.data");
            file.delete();
        } catch (Exception e) {
            e.printStackTrace();
        }


        if(type.equals("") && key.equals("")) {
            Intent intent = new Intent(getApplication(), Login.class);
            intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
            startActivity(intent);
        }
        stopSelf();
    }
}
