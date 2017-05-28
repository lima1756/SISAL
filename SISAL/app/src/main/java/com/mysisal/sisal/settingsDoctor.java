package com.mysisal.sisal;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.text.SpannableString;
import android.text.style.RelativeSizeSpan;
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
import android.widget.Toast;

import org.w3c.dom.Text;

public class settingsDoctor extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {

    Menu optionsMenu;
    MenuItem logOutItem;
    MenuItem synchItem;
    private NavigationView navigationView;

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

        navigationView = (NavigationView) findViewById(R.id.nav_view);
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

        SharedPreferences settings = getApplicationContext().getSharedPreferences("settings", 0);
        final Boolean notifications = settings.getBoolean("notifications", true);

        CheckBox checkBox = (CheckBox) findViewById(R.id.notificationsMedic);
        checkBox.setChecked(notifications);


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

    public final void save(){
        Spinner opciones = (Spinner) findViewById(R.id.select);
        String opcion = (String) opciones.getSelectedItem();
        final SharedPreferences settings = getApplicationContext().getSharedPreferences("settings", 0);
        settings.edit().remove("titleSize").commit();
        settings.edit().remove("textSize").commit();
        settings.edit().remove("barTextSize").commit();
        settings.edit().remove("menuOptionsTextSize").commit();
        settings.edit().remove("menuTitleTextSize").commit();
        settings.edit().remove("notifications").commit();

        Toast.makeText(getApplicationContext(), "Guardado!",
                Toast.LENGTH_LONG).show();

        SharedPreferences.Editor editor = settings.edit();
        switch(opcion)
        {
            case "Pequeña":
                editor.putInt("titleSize", 25);
                editor.putInt("textSize", 15);
                editor.putInt("barTextSize", 20);
                editor.putFloat("menuOptionsTextSize", .8f);
                editor.putFloat("menuTitleTextSize", 1f);
                break;
            case "Mediana":
                editor.putInt("titleSize", 30);
                editor.putInt("textSize", 20);
                editor.putInt("barTextSize", 25);
                editor.putFloat("menuOptionsTextSize", 1f);
                editor.putFloat("menuTitleTextSize", 1.5f);
                break;
            case "Grande":
                editor.putInt("titleSize", 40);
                editor.putInt("textSize", 30);
                editor.putInt("barTextSize", 35);
                editor.putFloat("menuOptionsTextSize", 2f);
                editor.putFloat("menuTitleTextSize", 3f);
                break;
        }
        CheckBox checkBox = (CheckBox) findViewById(R.id.notificationsMedic);
        if(checkBox.isChecked())
        {
            editor.putBoolean("notifications", true);
            Intent intent = new Intent(getApplicationContext(), updateInfo.class);
            startService(intent);
        }
        else
        {
            editor.putBoolean("notifications", false);
            Alarms alarms = Alarms.getInstance(getApplicationContext());
            alarms.unSetAll(getApplicationContext());

        }
        editor.apply();
        Intent intent = new Intent(getApplicationContext(), settingsDoctor.class);
        startActivity(intent);


    }

    private void adaptText()
    {
        final SharedPreferences settings = getApplicationContext().getSharedPreferences("settings", 0);
        //Titulo1

        TextView titulo = (TextView) findViewById(R.id.titulo1);
        titulo.setTextSize(settings.getInt("titleSize", 30));

        //CheckBox

        CheckBox cb = (CheckBox) findViewById(R.id.notificationsMedic);
        cb.setTextSize(settings.getInt("titleSize", 30));

        //btn save

        Button btnSave = (Button) findViewById(R.id.btnSave);
        btnSave.setTextSize(settings.getInt("titleSize", 30));

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
}
