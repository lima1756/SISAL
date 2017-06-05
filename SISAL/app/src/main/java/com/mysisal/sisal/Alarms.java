package com.mysisal.sisal;

import android.app.AlarmManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.util.Log;
import android.view.View;
import android.widget.TextView;

import org.apache.commons.io.IOUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.io.Serializable;
import java.io.StringWriter;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;

/**
 * Created by Luis Iván Morett on 20/05/2017.
 *
 */

class Alarms implements Serializable {

    private ArrayList<Integer> IDs = new ArrayList<>();

    private static Alarms ourInstance;

    static Alarms getInstance(Context context) {
        File file = context.getFileStreamPath("Alarms.data");
        if(file.exists())
        {
            try{
                FileInputStream fis = context.openFileInput("Alarms.data");
                ObjectInputStream ois = new ObjectInputStream(fis);
                ourInstance = (Alarms) ois.readObject();

            } catch(Exception e) {
                ourInstance = new Alarms();
                Log.d("Response_Exception", e.getMessage());
            }
        }
        else
        {
            ourInstance = new Alarms();
        }
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
            Log.d("Response_setAlarmsDates", "true");
            JSONArray citas = datosJSON.getJSONArray("citas");
            for(int i = 0; i < citas.length(); i++)
            {
                JSONObject eachDato = citas.getJSONObject(i);

                String inputPattern = "yyyy-MM-dd HH:mm:ss";
                SimpleDateFormat inputFormat = new SimpleDateFormat(inputPattern);

                Date date = null;

                try {
                    date = inputFormat.parse((String)eachDato.get("fecha_hora"));
                } catch (ParseException e) {
                    e.printStackTrace();
                }

                Calendar cita = Calendar.getInstance();
                Calendar citaMinus = Calendar.getInstance();
                cita.setTime(date);
                citaMinus.setTime(date);


                citaMinus.add(Calendar.HOUR, -1);

                setAlarm("Proxima Cita en una hora", cita.getTime().toString(), citaMinus, context);
                citaMinus.add(Calendar.HOUR, -23);

                setAlarm("Proxima Cita en un dia", cita.getTime().toString(), citaMinus, context);


            }
        } catch(JSONException e) {
            try {
                datosJSON = new JSONObject(datos);
                JSONArray citas = datosJSON.getJSONArray("citas");
                for (int i = 0; i < citas.length(); i++) {
                    JSONObject eachDato = citas.getJSONObject(i);

                    String inputPattern = "yyyy-MM-dd HH:mm:ss";
                    SimpleDateFormat inputFormat = new SimpleDateFormat(inputPattern);

                    Date date = null;

                    try {
                        date = inputFormat.parse((String) eachDato.get("fecha_hora"));
                    } catch (ParseException exe) {
                        e.printStackTrace();
                    }

                    Calendar cita = Calendar.getInstance();
                    Calendar citaMinus = Calendar.getInstance();
                    cita.setTime(date);
                    citaMinus.setTime(date);


                    citaMinus.add(Calendar.MINUTE, -10);
                    Log.d("Response_dates", citaMinus.toString());
                    setAlarm("Proxima Cita en diez minutos", cita.getTime().toString(), citaMinus, context, eachDato.getString("id_usuario"));

                }

            }   catch(JSONException ex){ }

        }

        saveClass(context);
    }

    public void setAlarm(String Titulo, String Contenido, long cada, Calendar inicio, Context context)
    {

        Intent intent = new Intent(context, notifications.class);
        intent.putExtra("Title", Titulo);
        intent.putExtra("Content", Contenido);
        Integer id = (int) System.currentTimeMillis();
        IDs.add(id);
        PendingIntent pendingIntent = PendingIntent.getBroadcast(context, id, intent, 0);

        AlarmManager am = (AlarmManager)context.getSystemService(context.ALARM_SERVICE);
        am.setRepeating(AlarmManager.RTC_WAKEUP, inicio.getTimeInMillis(), cada, pendingIntent);

    }

    public void setAlarm(String Titulo, String Contenido, Calendar notificacion, Context context)
    {
        Intent intent = new Intent(context, notifications.class);
        intent.putExtra("Title", Titulo);
        intent.putExtra("Content", Contenido);
        Integer id = (int) System.currentTimeMillis();
        IDs.add(id);
        PendingIntent pendingIntent = PendingIntent.getBroadcast(context, id, intent, 0);

        AlarmManager am = (AlarmManager)context.getSystemService(context.ALARM_SERVICE);
        am.set(AlarmManager.RTC_WAKEUP, notificacion.getTimeInMillis(), pendingIntent);
    }

    public void setAlarm(String Titulo, String Contenido, Calendar notificacion, Context context, String idDate)
    {
        Intent intent = new Intent(context, notifications.class);
        intent.putExtra("Title", Titulo);
        intent.putExtra("Content", Contenido);
        intent.putExtra("id", idDate);
        Integer id = (int) System.currentTimeMillis();
        IDs.add(id);
        PendingIntent pendingIntent = PendingIntent.getBroadcast(context, id, intent, 0);

        AlarmManager am = (AlarmManager)context.getSystemService(context.ALARM_SERVICE);
        am.set(AlarmManager.RTC_WAKEUP, notificacion.getTimeInMillis(), pendingIntent);
    }



    public void setIntentServiceAlarm(Intent action, Context context, Calendar inicio, long cada, int code)
    {
        Calendar time = Calendar.getInstance();
        time.add(Calendar.SECOND, 10);


        PendingIntent pendingIntent = PendingIntent.getService(context, code, action, 0);

        AlarmManager am = (AlarmManager)context.getSystemService(context.ALARM_SERVICE);
        am.setRepeating(AlarmManager.RTC_WAKEUP, inicio.getTimeInMillis(), cada*3600000, pendingIntent);

    }

    public void unSetAlarm(String Titulo, String Contenido, Context context, Integer position)
    {
        Intent intent = new Intent(context, notifications.class);
        intent.putExtra("Title", Titulo);
        intent.putExtra("Content", Contenido);

        Integer id = IDs.get(position);


        Boolean existIntent = PendingIntent.getBroadcast(context, id, intent, PendingIntent.FLAG_NO_CREATE) != null;
        Log.d("Response_PendingI", existIntent.toString());


        PendingIntent pendingIntent = PendingIntent.getBroadcast(context, id, intent, PendingIntent.FLAG_UPDATE_CURRENT);

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
            int i = 0;
            for(i = 0; i < medicamentos.length(); i++)
            {
                JSONObject eachDato = medicamentos.getJSONObject(i);

                String inputPattern = "yyyy-MM-dd HH:mm:ss";
                String dia = "dd";
                String mes = "MM";
                String anio = "yyyy";
                String hora = "HH";
                String min = "mm";

                SimpleDateFormat inputFormat = new SimpleDateFormat(inputPattern);
                SimpleDateFormat outputFormatDia = new SimpleDateFormat(dia);
                SimpleDateFormat outputFormatMes = new SimpleDateFormat(mes);
                SimpleDateFormat outputFormatAnio = new SimpleDateFormat(anio);
                SimpleDateFormat outputFormatHora = new SimpleDateFormat(hora);
                SimpleDateFormat outputFormatMin = new SimpleDateFormat(min);

                Date date;
                String strDia = null;
                String strMes = null;
                String strAnio = null;
                String strHora = null;
                String strMin = null;
                try {
                    date = inputFormat.parse((String)eachDato.get("inicio"));
                    strDia = outputFormatDia.format(date);
                    strMes = outputFormatMes.format(date);
                    strAnio = outputFormatAnio.format(date);
                    strHora = outputFormatHora.format(date);
                    strMin = outputFormatMin.format(date);
                } catch (java.text.ParseException e) {
                    e.printStackTrace();
                }

                Calendar cal = Calendar.getInstance();
                cal.set(Integer.parseInt(strAnio), Integer.parseInt(strMes)-1, Integer.parseInt(strDia), Integer.parseInt(strHora), Integer.parseInt(strMin), 0);

                Calendar now = Calendar.getInstance();
                while(cal.before(now)) {
                    cal.add(Calendar.HOUR_OF_DAY, Integer.parseInt((String)eachDato.get("cada")));
                }

                unSetAlarm(eachDato.getString("nombre"),"Es hora de tomar tu medicamento :)", context, i);

            }
            JSONArray citas = datosJSON.getJSONArray("citas");
            int a = i;
            i = 0;
            for(; i < citas.length()*2; i++, a++)
            {
                JSONObject eachDato = (JSONObject) citas.getJSONObject(i);

                String inputPattern = "yyyy-MM-dd HH:mm:ss";
                String outputPattern = "dd-MMM-yyyy h:mm a";
                SimpleDateFormat inputFormat = new SimpleDateFormat(inputPattern);
                SimpleDateFormat outputFormat = new SimpleDateFormat(outputPattern);

                Date date = null;

                try {
                    date = inputFormat.parse((String)eachDato.get("fecha_hora"));
                } catch (ParseException e) {
                    e.printStackTrace();
                }

                Calendar cita = Calendar.getInstance();
                cita.setTime(date);

                unSetAlarm("Proxima Cita en una hora", cita.getTime().toString(), context, a++);

                unSetAlarm("Proxima Cita en un dia", cita.getTime().toString(), context, a);


            }
        } catch(JSONException e) {
            try {
                datosJSON = new JSONObject(datos);
                JSONArray citas = datosJSON.getJSONArray("citas");
                for (int i = 0; i < citas.length(); i++) {
                    JSONObject eachDato = citas.getJSONObject(i);

                    String inputPattern = "yyyy-MM-dd HH:mm:ss";
                    SimpleDateFormat inputFormat = new SimpleDateFormat(inputPattern);

                    Date date = null;

                    try {
                        date = inputFormat.parse((String) eachDato.get("fecha_hora"));
                    } catch (ParseException exe) {
                        e.printStackTrace();
                    }

                    Calendar cita = Calendar.getInstance();
                    Calendar citaMinus = Calendar.getInstance();
                    cita.setTime(date);
                    citaMinus.setTime(date);


                    citaMinus.add(Calendar.MINUTE, -10);
                    unSetAlarm("Proxima Cita en diez minutos", cita.getTime().toString(), context, i);

                }

            }   catch(JSONException ex){ }
        }
        File file = context.getFileStreamPath("Alarms.data");
        file.delete();
        IDs.clear();
    }

    private void saveClass(final Context context)
    {
        ObjectOutputStream objectOut = null;
        try {
            FileOutputStream fileOut = context.getApplicationContext().openFileOutput("Alarms.data", context.MODE_PRIVATE);
            objectOut = new ObjectOutputStream(fileOut);
            objectOut.writeObject(ourInstance);
            fileOut.getFD().sync();
        } catch (IOException e) {
            Log.e("SharedVariable", e.getMessage(), e);
        } finally {
            if (objectOut != null) {
                try {
                    objectOut.close();
                } catch (IOException e) {
                    Log.e("SharedVariable", e.getMessage(), e);
                }
            }
        }
    }

    public boolean isEmpty()
    {
        return !(IDs.size()>0);
    }
}
