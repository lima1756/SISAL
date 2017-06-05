package com.mysisal.sisal;

import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.text.SpannableString;
import android.text.style.RelativeSizeSpan;
import android.util.Log;
import android.view.View;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.LinearLayout;
import android.widget.TextView;

import org.apache.commons.io.IOUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.FileInputStream;
import java.io.StringWriter;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;

public class myMedicines extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {

    Menu optionsMenu;
    MenuItem logOutItem;
    MenuItem synchItem;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_my_medicines);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);


        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.setDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);

        final LinearLayout miLayOut = (LinearLayout)findViewById(R.id.layoutContent);
        TextView[] Titles = new TextView[255];
        TextView[] Contents = new TextView[255];

        String datos = "";
        FileInputStream inputStream;
        try{
            inputStream = openFileInput("data.json");
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
                JSONObject eachDato = (JSONObject) medicamentos.getJSONObject(i);
                Titles[i] = new TextView(this);

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
                } catch (ParseException e) {
                    e.printStackTrace();
                }

                Calendar cal = Calendar.getInstance();
                cal.set(Integer.parseInt(strAnio), Integer.parseInt(strMes)-1, Integer.parseInt(strDia), Integer.parseInt(strHora), Integer.parseInt(strMin), 0);
                Calendar now = Calendar.getInstance();
                Titles[i].setText((String)eachDato.get("nombre"));

                while(cal.before(now)) {
                    cal.add(Calendar.HOUR_OF_DAY, Integer.parseInt((String)eachDato.get("cada")));
                }

                Contents[i] = new TextView(this);
                Contents[i].setText("Inicio: " + str + "\nCada: " + (String)eachDato.get("cada") + " horas\nDurante: " + (String)eachDato.get("durante") + " horas\nIndicaciones: " + (String)eachDato.get("indicaciones") + "\nSiguiente toma: "
                            + cal.getTime().toString());

                Titles[i].setTextSize(30);
                Titles[i].setTextColor(Color.BLUE);
                Contents[i].setTextSize(20);
                Contents[i].setVisibility(View.GONE);
                final int val = i+1025;
                Contents[i].setId(val);
                miLayOut.addView(Titles[i]);
                miLayOut.addView(Contents[i]);
                Titles[i].setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        TextView act = (TextView) findViewById(val);
                        act.setVisibility(act.isShown() ? View.GONE : View.VISIBLE );
                    }
                });
            }
        } catch(JSONException e) {

        }

        SharedPreferences settings = getApplicationContext().getSharedPreferences("settings", 0);
        Menu menu = navigationView.getMenu();

        MenuItem item1 = menu.findItem(R.id.nav_config);
        SpannableString s = new SpannableString(item1.getTitle()); //get text from our menu item.
        s.setSpan(new RelativeSizeSpan(settings.getFloat("menuOptionsTextSize", 1f)),0,s.length(),0); //here is where we are actually setting the size with a float (proportion).
        item1.setTitle(s);

        MenuItem item2 = menu.findItem(R.id.nav_dates);
        s = new SpannableString(item2.getTitle()); //get text from our menu item.
        s.setSpan(new RelativeSizeSpan(settings.getFloat("menuOptionsTextSize", 1f)),0,s.length(),0); //here is where we are actually setting the size with a float (proportion).
        item2.setTitle(s);

        MenuItem item3 = menu.findItem(R.id.nav_start);
        s = new SpannableString(item3.getTitle()); //get text from our menu item.
        s.setSpan(new RelativeSizeSpan(settings.getFloat("menuOptionsTextSize", 1f)),0,s.length(),0); //here is where we are actually setting the size with a float (proportion).
        item3.setTitle(s);

        MenuItem item4 = menu.findItem(R.id.nav_medicines);
        s = new SpannableString(item4.getTitle()); //get text from our menu item.
        s.setSpan(new RelativeSizeSpan(settings.getFloat("menuOptionsTextSize", 1f)),0,s.length(),0); //here is where we are actually setting the size with a float (proportion).
        item4.setTitle(s);

        MenuItem item5 = menu.findItem(R.id.nav_doctors);
        s = new SpannableString(item5.getTitle()); //get text from our menu item.
        s.setSpan(new RelativeSizeSpan(settings.getFloat("menuOptionsTextSize", 1f)),0,s.length(),0); //here is where we are actually setting the size with a float (proportion).
        item5.setTitle(s);
    }

    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.my_doctors, menu);
        //  store the menu to var when creating options menu
        optionsMenu = menu;
        logOutItem = optionsMenu.findItem(R.id.logOut);
        logOutItem.setOnMenuItemClickListener(
                new MenuItem.OnMenuItemClickListener() {

                    @Override
                    public boolean onMenuItemClick(MenuItem item) {
                        Intent x = new Intent(getApplicationContext(), LogOut.class);
                        startService(x);
                        return true;
                    }
                });
        synchItem = optionsMenu.findItem(R.id.Synch);
        synchItem.setOnMenuItemClickListener(
                new MenuItem.OnMenuItemClickListener() {

                    @Override
                    public boolean onMenuItemClick(MenuItem item) {
                        Intent x = new Intent(getApplicationContext(), updateInfo.class);
                        startService(x);
                        return true;
                    }
                });
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();

        if (id == R.id.nav_medicines) {
            Intent intent = new Intent(getApplicationContext(), myMedicines.class);
            startActivity(intent);
        } else if (id == R.id.nav_dates) {
            Intent intent = new Intent(getApplicationContext(), myDates.class);
            startActivity(intent);
        } else if (id == R.id.nav_doctors) {
            Intent intent = new Intent(getApplicationContext(), myDoctorsActivity.class);
            startActivity(intent);
        } else if (id == R.id.nav_config) {
            Intent intent = new Intent(getApplicationContext(), settings.class);
            startActivity(intent);
        } else if (id == R.id.nav_start) {
            Intent intent = new Intent(getApplicationContext(), patientStartActivity.class);
            startActivity(intent);
        }


        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }
}
