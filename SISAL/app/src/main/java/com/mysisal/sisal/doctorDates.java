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
import android.widget.Toast;

import org.apache.commons.io.IOUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.FileInputStream;
import java.io.StringWriter;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;

public class doctorDates extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {

    Menu optionsMenu;
    MenuItem logOutItem;
    MenuItem synchItem;

    private SharedPreferences settings;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_doctor_dates);
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

        settings = getApplicationContext().getSharedPreferences("settings", 0);

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
        JSONArray citas;
        try {
            datosJSON = new JSONObject(datos);
            citas = datosJSON.getJSONArray("citas");
            for(int i = 0; i < citas.length(); i++)
            {
                final JSONObject eachDato = citas.getJSONObject(i);
                Titles[i] = new TextView(this);

                String inputPattern = "yyyy-MM-dd HH:mm:ss";
                String outputPattern = "dd-MMM-yyyy h:mm a";
                SimpleDateFormat inputFormat = new SimpleDateFormat(inputPattern);
                SimpleDateFormat outputFormat = new SimpleDateFormat(outputPattern);

                Date date = null;
                String str = null;

                try {
                    date = inputFormat.parse((String)eachDato.get("fecha_hora"));
                    str = outputFormat.format(date);
                } catch (ParseException e) {
                    e.printStackTrace();
                }

                Titles[i].setText(str);



                Titles[i].setTextSize(settings.getInt("titleSize", 30));
                Titles[i].setTextColor(Color.BLUE);
                miLayOut.addView(Titles[i]);
                Titles[i].setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {

                        try {
                            Log.d("Response_clickListener", "Entro a listener");
                            Intent intent = new Intent(getApplicationContext(), pinActivity.class);
                            intent.putExtra("id", eachDato.getString("id_usuario"));
                            intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                            getApplicationContext().startActivity(intent);
                        }
                        catch(Exception e){
                            Log.d("Response_exception", e.getMessage());

                        }
                    }
                });

            }
        } catch(JSONException e) {

        }

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

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();

        if (id == R.id.nav_config) {
            Intent intent = new Intent(getApplicationContext(), settingsDoctor.class);
            startActivity(intent);
        } else if (id == R.id.nav_dates) {
            Intent intent = new Intent(getApplicationContext(), doctorDates.class);
            startActivity(intent);
        } else if (id == R.id.nav_start) {
            Intent intent = new Intent(getApplicationContext(), startMedic.class);
            startActivity(intent);
        }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }
}
