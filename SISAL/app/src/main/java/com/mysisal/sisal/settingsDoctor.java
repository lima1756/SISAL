package com.mysisal.sisal;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.Spinner;
import android.widget.TextView;

import org.w3c.dom.Text;

public class settingsDoctor extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        setContentView(R.layout.activity_settings_doctor);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);


        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.setDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);

        //SPINNER
        Spinner opciones = (Spinner) findViewById(R.id.select);

        String[] items = new String[]{"Pequeña", "Mediana", "Grande"};
        SpinnerAdapter adapter = new SpinnerAdapter(this, R.layout.support_simple_spinner_dropdown_item, items);
        opciones.setAdapter(adapter);
        Integer x = opciones.getChildCount();

        adaptText();

        Button btnSave = (Button) findViewById(R.id.btnSave);
        btnSave.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                save();
            }
        });

    }

    private class SpinnerAdapter extends ArrayAdapter<String> {
        Context context;
        String[] items = new String[] {};

        public SpinnerAdapter(final Context context,
                              final int textViewResourceId, final String[] objects) {
            super(context, textViewResourceId, objects);
            this.items = objects;
            this.context = context;
        }

        @Override
        public View getDropDownView(int position, View convertView,
                                    ViewGroup parent) {

            if (convertView == null) {
                LayoutInflater inflater = LayoutInflater.from(context);
                convertView = inflater.inflate(
                        android.R.layout.simple_spinner_item, parent, false);
            }

            TextView tv = (TextView) convertView
                    .findViewById(android.R.id.text1);
            tv.setText(items[position]);
            switch(position){
                case 0:
                    tv.setTextSize(15);
                    break;
                case 1:
                    tv.setTextSize(20);
                    break;
                case 2:
                    tv.setTextSize(30);
                    break;
                default:
                    tv.setTextSize(100);
                    break;
            }


            return convertView;
        }

        @Override
        public View getView(int position, View convertView, ViewGroup parent) {
            if (convertView == null) {
                LayoutInflater inflater = LayoutInflater.from(context);
                convertView = inflater.inflate(
                        android.R.layout.simple_spinner_item, parent, false);
            }

            // android.R.id.text1 is default text view in resource of the android.
            // android.R.layout.simple_spinner_item is default layout in resources of android.

            TextView tv = (TextView) convertView
                    .findViewById(android.R.id.text1);
            tv.setText(items[position]);
            switch(position){
                case 0:
                    tv.setTextSize(15);
                    break;
                case 1:
                    tv.setTextSize(20);
                    break;
                case 2:
                    tv.setTextSize(30);
                    break;
                default:
                    tv.setTextSize(100);
                    break;
            }
            return convertView;
        }
    };

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
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.settings_doctor, menu);
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

        if (id == R.id.nav_config) {
            Intent intent = new Intent(getApplicationContext(), settingsDoctor.class);
            startActivity(intent);
        } else if (id == R.id.nav_dates) {
            Intent intent = new Intent(getApplicationContext(), doctorDates.class);
            startActivity(intent);
        }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }

    public final void save(){
        Spinner opciones = (Spinner) findViewById(R.id.select);
        String opcion = (String) opciones.getSelectedItem();
        final SharedPreferences settings = getApplicationContext().getSharedPreferences("settings", 0);
        settings.edit().remove("titleSize").commit();
        settings.edit().remove("textSize").commit();
        settings.edit().remove("barTextSize").commit();
        settings.edit().remove("menuOptionsTextSize").commit();
        settings.edit().remove("menuTitleTextSize").commit();


        SharedPreferences.Editor editor = settings.edit();
        switch(opcion)
        {
            case "Pequeña":
                editor.putInt("titleSize", 25);
                editor.putInt("textSize", 15);
                editor.putInt("barTextSize", 20);
                editor.putInt("menuOptionsTextSize", 25);
                editor.putInt("menuTitleTextSize", 35);
                break;
            case "Mediana":
                editor.putInt("titleSize", 30);
                editor.putInt("textSize", 20);
                editor.putInt("barTextSize", 25);
                editor.putInt("menuOptionsTextSize", 30);
                editor.putInt("menuTitleTextSize", 40);
                break;
            case "Grande":
                editor.putInt("titleSize", 40);
                editor.putInt("textSize", 30);
                editor.putInt("barTextSize", 35);
                editor.putInt("menuOptionsTextSize", 40);
                editor.putInt("menuTitleTextSize", 50);
                break;
        }
        editor.apply();
        adaptText();
    }

    private void adaptText()
    {
        final SharedPreferences settings = getApplicationContext().getSharedPreferences("settings", 0);
        //Titulo1

        TextView titulo = (TextView) findViewById(R.id.titulo1);
        titulo.setTextSize(settings.getInt("titleSize", 30));

        //CheckBox

        CheckBox cb = (CheckBox) findViewById(R.id.notifications);
        cb.setTextSize(settings.getInt("titleSize", 30));

        //btn save

        Button btnSave = (Button) findViewById(R.id.btnSave);
        btnSave.setTextSize(settings.getInt("titleSize", 30));
    }
}
