package com.mysisal.sisal;

import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
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
import android.view.ViewParent;
import android.widget.LinearLayout;
import android.widget.TextView;

import org.apache.commons.io.IOUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import org.w3c.dom.Text;

import java.io.FileInputStream;
import java.io.StringWriter;

public class myDoctorsActivity extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {

    private Menu optionsMenu;
    private MenuItem myItem;
    private SharedPreferences settings;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        settings = getApplicationContext().getSharedPreferences("settings", 0);
        setContentView(R.layout.activity_my_doctors);
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
        JSONObject datosJSON = new JSONObject();
        JSONArray medicos = null;
        try {
            datosJSON = new JSONObject(datos);
            medicos = datosJSON.getJSONArray("medicos");
            for(int i = 0; i < medicos.length(); i++)
            {
                JSONObject eachDato = (JSONObject) medicos.getJSONObject(i);
                Titles[i] = new TextView(this);
                Titles[i].setText((String)eachDato.get("nombre") + " " + (String)eachDato.get("apellidoPaterno") + " " + (String)eachDato.get("apellidoMaterno"));
                Contents[i] = new TextView(this);
                Contents[i].setText("Especialidad: " + (String)eachDato.get("especialidad") + "\nDomicilio consultorio: " + (String)eachDato.get("domicilioConsultorio") + "\nTelefono Emergencias:" + (String)eachDato.get("telEmergencias") +
                "\nCelular de emergencias: " + (String)eachDato.get("celEmergencias") + "\nFacebook: " + (String)eachDato.get("facebook")  +"\nTwitter: " + (String)eachDato.get("twitter"));
            }
        } catch(JSONException e) {

        }
        for(int i = 0; i < medicos.length(); i++)
        {
            Titles[i].setTextSize(settings.getInt("titleSize", 30));
            Titles[i].setTextColor(Color.BLUE);
            Contents[i].setTextSize(settings.getInt("textSize", 20));
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
        myItem = optionsMenu.findItem(R.id.logOut);
        myItem.setOnMenuItemClickListener(
                new MenuItem.OnMenuItemClickListener() {

                    @Override
                    public boolean onMenuItemClick(MenuItem item) {
                        new LogOut(getApplicationContext());
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

        if (id == R.id.nav_clinic) {
            Log.d("Response_menu", "Clinica");
        } else if (id == R.id.nav_dates) {
            Intent intent = new Intent(getApplicationContext(), myDates.class);
            startActivity(intent);
        } else if (id == R.id.nav_doctors) {
            Intent intent = new Intent(getApplicationContext(), myDoctorsActivity.class);
            startActivity(intent);
        } else if (id == R.id.nav_medicines) {
            Intent intent = new Intent(getApplicationContext(), myMedicines.class);
            startActivity(intent);
        } else if (id == R.id.nav_config) {
            Intent intent = new Intent(getApplicationContext(), settings.class);
            startActivity(intent);
        }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }
}
