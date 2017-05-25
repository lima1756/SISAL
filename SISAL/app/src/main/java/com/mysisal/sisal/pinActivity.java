package com.mysisal.sisal;

import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Color;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import java.security.MessageDigest;

public class pinActivity extends AppCompatActivity {

    private EditText pin;
    private TextView text;
    private Integer oportunities;
    private Intent past;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_pin);

        SharedPreferences settings = getApplicationContext().getSharedPreferences("settings", 0);

        setContentView(R.layout.activity_pin);


        text = (TextView) findViewById(R.id.txtVPin);
        text.setTextSize(settings.getInt("titleSize", 30));

        past = getIntent();

        oportunities = 4;

        pin = (EditText) findViewById(R.id.pinCode);

        Button b = (Button) findViewById(R.id.btnPin);

        b.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String txt = pin.getText().toString();
                Log.d("Response_pin", txt);
                String cypherPass = "";

                try{
                    MessageDigest digest = MessageDigest.getInstance("SHA-256");
                    byte[] hash = digest.digest(txt.getBytes("UTF-8"));
                    StringBuffer hexString = new StringBuffer();

                    for (int i = 0; i < hash.length; i++) {
                        String hex = Integer.toHexString(0xff & hash[i]);
                        if(hex.length() == 1) hexString.append('0');
                        hexString.append(hex);
                    }
                    cypherPass = hexString.toString();
                } catch(Exception ex){
                    cypherPass = "";
                }
                Log.d("Response_CypherPin", cypherPass);
                SharedPreferences datos = getApplicationContext().getSharedPreferences("pinData", 0);
                final String pin = datos.getString("pin", "");
                if(pin.equals(cypherPass))
                {
                    Intent intent = new Intent(getApplicationContext(), PatientPreview.class);
                    intent.putExtra("id", past.getStringExtra("id"));
                    startActivity(intent);
                }
                else
                {
                    text.setText("Pin erroneo, porfavor vuelva a intentar");
                    text.setTextColor(Color.RED);
                    oportunities--;
                    if(oportunities != 0)
                        Toast.makeText(getApplicationContext(), "Quedan "  + oportunities.toString() + " oportunidades",
                                Toast.LENGTH_LONG).show();
                    else
                    {
                        Toast.makeText(getApplicationContext(), "Cierre de sesión preventivo",
                                Toast.LENGTH_LONG).show();
                        Intent x = new Intent(getApplicationContext(), LogOut.class);
                        startService(x);
                    }
                }
            }
        });
    }
}
