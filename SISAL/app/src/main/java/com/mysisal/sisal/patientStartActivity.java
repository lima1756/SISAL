package com.mysisal.sisal;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.net.Uri;
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
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.google.android.gms.maps.CameraUpdate;
import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.MapView;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.MarkerOptions;

public class patientStartActivity extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {

    Menu optionsMenu;
    MenuItem logOutItem;
    MenuItem synchItem;
    private SharedPreferences settings;
    MapView mapView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        settings = getApplicationContext().getSharedPreferences("settings", 0);
        setContentView(R.layout.activity_patient_start);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.setDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);

        mapView = (MapView) findViewById(R.id.mapa);
        OnMapReadyCallback onMapReadyCallback = new OnMapReadyCallback() {
            @Override
            public void onMapReady(GoogleMap googleMap) {
                LatLng ubicacion = new LatLng(25.7861512, -108.9884567);
                googleMap.addMarker(new MarkerOptions().position(ubicacion).title("Clinica San AntonioAv. Independencia 1748 Poniente. Col San Francisco Los Mochis, Sinaloa"));
                CameraUpdate cameraPosition = CameraUpdateFactory.newLatLngZoom(ubicacion, 15);

                googleMap.moveCamera(cameraPosition);
                googleMap.animateCamera(cameraPosition);

            }
        };
        mapView.onCreate(savedInstanceState);
        mapView.getMapAsync(onMapReadyCallback);

        TextView titulo = (TextView) findViewById(R.id.clinicNameView);
        titulo.setTextSize(settings.getInt("titleSize", 30) + 15);

        TextView slogan = (TextView) findViewById(R.id.slogan);
        slogan.setTextSize(settings.getInt("textSize", 20) + 3);
        slogan.setTextColor(Color.GRAY);

        TextView servicios = (TextView) findViewById(R.id.Servicios);
        servicios.setTextSize(settings.getInt("titleSize", 30)+5);


        final TextView listaServicios = (TextView) findViewById(R.id.listaServicios);
        listaServicios.setTextSize(settings.getInt("textSize", 20));
        listaServicios.setVisibility(View.GONE);
        servicios.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                listaServicios.setVisibility(listaServicios.isShown() ? View.GONE : View.VISIBLE );
            }
        });

        final LinearLayout miLayOut = (LinearLayout)findViewById(R.id.contactContainer);
        miLayOut.setVisibility(View.GONE);
        miLayOut.setVisibility(View.GONE);
        TextView contacto = (TextView) findViewById(R.id.contacto);
        contacto.setTextSize(settings.getInt("titleSize", 30)+5);
        contacto.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                miLayOut.setVisibility(miLayOut.isShown() ? View.GONE : View.VISIBLE );
            }
        });

        TextView telView = (TextView) findViewById(R.id.telView);
        telView.setTextSize(settings.getInt("titleSize", 30));

        TextView tel1 = (TextView) findViewById(R.id.tel1);
        tel1.setTextSize(settings.getInt("textSize", 20));
        tel1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String uri = "tel:815-05-61" ;
                Intent intent = new Intent(Intent.ACTION_DIAL);
                intent.setData(Uri.parse(uri));
                startActivity(intent);
            }
        });

        TextView tel2 = (TextView) findViewById(R.id.tel2);
        tel2.setTextSize(settings.getInt("textSize", 20));
        tel2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String uri = "tel:812-95-41" ;
                Intent intent = new Intent(Intent.ACTION_DIAL);
                intent.setData(Uri.parse(uri));
                startActivity(intent);
            }
        });

        TextView tel3 = (TextView) findViewById(R.id.tel3);
        tel3.setTextSize(settings.getInt("textSize", 20));
        tel3.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String uri = "tel:812-13-48" ;
                Intent intent = new Intent(Intent.ACTION_DIAL);
                intent.setData(Uri.parse(uri));
                startActivity(intent);
            }
        });

        TextView celView = (TextView) findViewById(R.id.celView);
        celView.setTextSize(settings.getInt("titleSize", 30));

        TextView cel1 = (TextView) findViewById(R.id.cel1);
        cel1.setTextSize(settings.getInt("textSize", 20));
        cel1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String uri = "tel:6681-12-2436" ;
                Intent intent = new Intent(Intent.ACTION_DIAL);
                intent.setData(Uri.parse(uri));
                startActivity(intent);
            }
        });

        TextView cel2 = (TextView) findViewById(R.id.cel2);
        cel2.setTextSize(settings.getInt("textSize", 20));
        cel2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String uri = "tel:6681-30-0267" ;
                Intent intent = new Intent(Intent.ACTION_DIAL);
                intent.setData(Uri.parse(uri));
                startActivity(intent);
            }
        });

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
            Intent x = new Intent(getApplicationContext(), LogOut.class);
            startService(x);
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.patient_start, menu);
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

    @Override
    protected void onPause() {
        mapView.onPause();
        super.onPause();
    }

    @Override
    protected void onDestroy()
    {
        mapView.onDestroy();
        super.onDestroy();

    }

    @Override
    public void onResume() {
        mapView.onResume();
        super.onResume();
    }


    @Override
    public void onLowMemory() {
        super.onLowMemory();
        mapView.onLowMemory();
    }

    @Override
    public void onStart()
    {
        mapView.onStart();
        super.onStart();
    }

    @Override
    public void onStop()
    {
        mapView.onStop();
        super.onStop();
    }

    @Override
    public void onSaveInstanceState(Bundle savedInstanceState)
    {
        mapView.onSaveInstanceState(savedInstanceState);
        super.onSaveInstanceState(savedInstanceState);
    }

}
