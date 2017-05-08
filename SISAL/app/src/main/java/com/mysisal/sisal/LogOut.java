package com.mysisal.sisal;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;

/**
 * Created by Luis Iván Morett on 07/05/2017.
 */

public class LogOut {
    public LogOut(Context x)
    {
        SharedPreferences preferences = x.getSharedPreferences("userData", 0);
        preferences.edit().remove("shared_pref_key").commit();

        String type = preferences.getString("type", "");
        String key = preferences.getString("key", "");
        if(type.equals("") && key.equals("")) {
            Intent intent = new Intent(x, startMedic.class);
            x.startActivity(intent);
        }
    }
}
