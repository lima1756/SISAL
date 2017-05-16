package com.mysisal.sisal;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.util.Log;

import org.apache.commons.io.IOUtils;

import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.StringWriter;

/**
 * Created by Luis Iván Morett on 07/05/2017.
 */

public class LogOut {
    public LogOut(Context x)
    {
        SharedPreferences preferences = x.getSharedPreferences("userData", 0);
        preferences.edit().remove("type").commit();
        preferences.edit().remove("key").commit();

        String type = preferences.getString("type", "");
        String key = preferences.getString("key", "");

        String filename = "data.json";
        FileOutputStream outputStream;

        try {
            outputStream = x.openFileOutput(filename, x.MODE_PRIVATE);
            String a = "";

            outputStream.write(a.getBytes());
            outputStream.close();
        } catch (Exception e) {
            e.printStackTrace();
        }


        if(type.equals("") && key.equals("")) {
            Intent intent = new Intent(x, Login.class);
            intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
            x.startActivity(intent);
        }
    }
}
