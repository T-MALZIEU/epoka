package com.example.epoka_tm;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;

public class MenuActivity extends Activity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_menu);

        Bundle extras =getIntent().getExtras();
        String id=extras.getString("id");
        String nom=extras.getString("nom");
        String prenom=extras.getString("prenom");
        TextView TxtBonjour = findViewById(R.id.TxtBonjour);
        TxtBonjour.setText("Bienvenue "+prenom+" "+nom);



    }

    public void go(View view){
        Bundle extras =getIntent().getExtras();
        String id=extras.getString("id");
        String nom=extras.getString("nom");
        String prenom=extras.getString("prenom");

        Intent intent =new Intent(getApplicationContext(),MissionActivity.class);
        intent.putExtra("nom",nom);
        intent.putExtra("prenom",prenom);
        intent.putExtra("id",id);
        startActivity(intent);

    }



}
