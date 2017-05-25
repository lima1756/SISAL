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

import org.json.JSONObject;

import java.security.MessageDigest;

public class newPinActivity extends AppCompatActivity {

    private EditText pin;
    private TextView text;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        SharedPreferences settings = getApplicationContext().getSharedPreferences("settings", 0);

        setContentView(R.layout.activity_new_pin);
        text = (TextView) findViewById(R.id.txtVNew);
        text.setTextSize(settings.getInt("titleSize", 30));

        pin = (EditText) findViewById(R.id.pinNewCode);

        Button b = (Button) findViewById(R.id.btnNewPin);

        b.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String txt = pin.getText().toString();
                if(txt.length()<4)
                {
                    text.setText("Porfavor un minimo de cuatro numeros");
                    text.setTextColor(Color.RED);
                }
                else
                {
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

                    SharedPreferences settings = getApplicationContext().getSharedPreferences("pinData", 0);
                    SharedPreferences.Editor editor = settings.edit();
                    editor.putString("pin", cypherPass);
                    editor.apply();

                    Intent intent = new Intent(getApplicationContext(), startMedic.class);
                    startActivity(intent);
                }
            }
        });

    }
}
