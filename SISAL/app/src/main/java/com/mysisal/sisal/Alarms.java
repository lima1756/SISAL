package com.mysisal.sisal;

import android.app.AlarmManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.util.Log;

import org.apache.commons.io.IOUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.FileInputStream;
import java.io.StringWriter;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;

/**
 * Created by Luis Iván Morett on 20/05/2017.
 *
 */

class Alarms {
    private static final Alarms ourInstance = new Alarms();

    static Alarms getInstance() {
        return ourInstance;
    }

    private Alarms() {
    }

    public void setAll(Context context)
    {

        String datos = "";
        FileInputStream inputStream;
        try{
            inputStream = context.openFileInput("data.json");
            StringWriter writer = new StringWriter();
            IOUtils.copy(inputStream, writer, "UTF8");
            datos = writer.toString();
        } catch(Exception e) {

        }
        JSONObject datosJSON;
        JSONArray medicamentos;
        try {
            datosJSON = new JSONObject(datos);

            medicamentos = datosJSON.getJSONArray("medicamentos");

            for(int i = 0; i < medicamentos.length(); i++)
            {
                JSONObject eachDato = medicamentos.getJSONObject(i);

                String inputPattern = "yyyy-MM-dd HH:mm:ss";
                String dia = "dd";
                String mes = "MM";
                String anio = "yyyy";
                String hora = "HH";
                String min = "mm";
                String output = "dd-MM-yy HH:mm a";

                SimpleDateFormat inputFormat = new SimpleDateFormat(inputPattern);
                SimpleDateFormat outputFormatDia = new SimpleDateFormat(dia);
                SimpleDateFormat outputFormatMes = new SimpleDateFormat(mes);
                SimpleDateFormat outputFormatAnio = new SimpleDateFormat(anio);
                SimpleDateFormat outputFormatHora = new SimpleDateFormat(hora);
                SimpleDateFormat outputFormatMin = new SimpleDateFormat(min);
                SimpleDateFormat outputFormat = new SimpleDateFormat(output);

                Date date = null;
                String strDia = null;
                String strMes = null;
                String strAnio = null;
                String strHora = null;
                String strMin = null;
                String str = null;
                try {
                    date = inputFormat.parse((String)eachDato.get("inicio"));
                    strDia = outputFormatDia.format(date);
                    strMes = outputFormatMes.format(date);
                    strAnio = outputFormatAnio.format(date);
                    strHora = outputFormatHora.format(date);
                    strMin = outputFormatMin.format(date);
                    str = outputFormat.format(date);
                } catch (java.text.ParseException e) {
                    e.printStackTrace();
                }

                Calendar cal = Calendar.getInstance();
                cal.set(Integer.parseInt(strAnio), Integer.parseInt(strMes)-1, Integer.parseInt(strDia), Integer.parseInt(strHora), Integer.parseInt(strMin), 0);

                Calendar now = Calendar.getInstance();
                while(cal.before(now)) {
                    cal.add(Calendar.HOUR_OF_DAY, Integer.parseInt((String)eachDato.get("cada")));
                }
                setAlarm(eachDato.getString("nombre"), "Es hora de tomar tu medicamento :)",Long.parseLong(eachDato.getString("cada"))*3600000, cal, context);
            }
        } catch(JSONException e) {

        }

    }

    public void setAlarm(String Titulo, String Contenido, long cada, Calendar inicio, Context context)
    {
        Intent intent = new Intent(context, notifications.class);
        intent.putExtra("Title", Titulo);
        intent.putExtra("Content", Contenido);
        PendingIntent pendingIntent = PendingIntent.getBroadcast(context, (int) System.currentTimeMillis(), intent, 0);

        AlarmManager am = (AlarmManager)context.getSystemService(context.ALARM_SERVICE);
        am.setRepeating(AlarmManager.RTC_WAKEUP, inicio.getTimeInMillis(), cada, pendingIntent);

    }

    public void setIntentAlarm(Intent action, Context context, Calendar inicio, long cada)
    {
        Calendar time = Calendar.getInstance();
        time.add(Calendar.SECOND, 10);


        PendingIntent pendingIntent = PendingIntent.getBroadcast(context, (int) System.currentTimeMillis(), action, 0);

        AlarmManager am = (AlarmManager)context.getSystemService(context.ALARM_SERVICE);
        am.setRepeating(AlarmManager.RTC_WAKEUP, inicio.getTimeInMillis(), cada, pendingIntent);

    }

    public void unSetAlarm(String Titulo, String Contenido, long cada, Calendar inicio, Context context)
    {
        Intent intent = new Intent(context, notifications.class);
        intent.putExtra("Title", Titulo);
        intent.putExtra("Content", Contenido);
        PendingIntent pendingIntent = PendingIntent.getService(context, 0, intent, PendingIntent.FLAG_UPDATE_CURRENT);

        AlarmManager am = (AlarmManager)context.getSystemService(context.ALARM_SERVICE);
        am.cancel(pendingIntent);
        pendingIntent.cancel();
    }

    public void unSetAll(Context context)
    {
        String datos = "";
        FileInputStream inputStream;
        try{
            inputStream = context.openFileInput("data.json");
            StringWriter writer = new StringWriter();
            IOUtils.copy(inputStream, writer, "UTF8");
            datos = writer.toString();
        } catch(Exception e) {

        }
        JSONObject datosJSON;
        JSONArray medicamentos;
        try {
            datosJSON = new JSONObject(datos);
            medicamentos = datosJSON.getJSONArray("medicamentos");
            for(int i = 0; i < medicamentos.length(); i++)
            {
                JSONObject eachDato = medicamentos.getJSONObject(i);

                String inputPattern = "yyyy-MM-dd HH:mm:ss";
                String dia = "dd";
                String mes = "MM";
                String anio = "yyyy";
                String hora = "HH";
                String min = "mm";
                String output = "dd-MM-yy HH:mm a";

                SimpleDateFormat inputFormat = new SimpleDateFormat(inputPattern);
                SimpleDateFormat outputFormatDia = new SimpleDateFormat(dia);
                SimpleDateFormat outputFormatMes = new SimpleDateFormat(mes);
                SimpleDateFormat outputFormatAnio = new SimpleDateFormat(anio);
                SimpleDateFormat outputFormatHora = new SimpleDateFormat(hora);
                SimpleDateFormat outputFormatMin = new SimpleDateFormat(min);
                SimpleDateFormat outputFormat = new SimpleDateFormat(output);

                Date date = null;
                String strDia = null;
                String strMes = null;
                String strAnio = null;
                String strHora = null;
                String strMin = null;
                String str = null;
                try {
                    date = inputFormat.parse((String)eachDato.get("inicio"));
                    strDia = outputFormatDia.format(date);
                    strMes = outputFormatMes.format(date);
                    strAnio = outputFormatAnio.format(date);
                    strHora = outputFormatHora.format(date);
                    strMin = outputFormatMin.format(date);
                    str = outputFormat.format(date);
                } catch (java.text.ParseException e) {
                    e.printStackTrace();
                }

                Calendar cal = Calendar.getInstance();
                cal.set(Integer.parseInt(strAnio), Integer.parseInt(strMes)-1, Integer.parseInt(strDia), Integer.parseInt(strHora), Integer.parseInt(strMin), 0);

                Calendar now = Calendar.getInstance();
                while(cal.before(now)) {
                    cal.add(Calendar.HOUR_OF_DAY, Integer.parseInt((String)eachDato.get("cada")));
                }
                Log.d("Response_unSetAll", "Ok...1");
                unSetAlarm(eachDato.getString("nombre"),"Es hora de tomar tu medicamento :)",Long.parseLong(eachDato.getString("cada"))*3600000, cal, context);

            }
        } catch(JSONException e) {

        }

    }
}
