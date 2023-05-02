package com.example.epoka_tm;

import androidx.appcompat.app.AppCompatActivity;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.StrictMode;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

public class MainActivity extends Activity {


    private String url;
    EditText etMatricule;
    EditText etMDP;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        etMatricule = findViewById(R.id.etMatricule);
        etMDP = findViewById(R.id.etMDP);
    }

    public void connect(View view){
        String m = etMatricule.getText().toString();
        String mdp = etMDP.getText().toString();
        url = "http://172.16.47.26/epoka/ServiceWeb/authentifier.php?matricule="+m+"&motdepasse="+mdp;
        getServerDataTexteBrut(url);
    }

    private void getServerDataTexteBrut(String urlString){
        StrictMode.ThreadPolicy  policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
        StrictMode.setThreadPolicy(policy);
        String ch="";
        InputStream is = null;
        try{
            URL url = new URL(urlString);
            HttpURLConnection connexion =(HttpURLConnection)url.openConnection();
            connexion.connect();
            is=connexion.getInputStream();
            BufferedReader br =new BufferedReader(new InputStreamReader(is));
 String ligne;
            while ((ligne=br.readLine())!=null){
                ch=ligne;
            };
            if (!"tt va mal".equals(ch)){
                String[] separe=ch.split(":");



                Intent intent =new Intent(getApplicationContext(),MenuActivity.class);
                intent.putExtra("nom",separe[1]);
                intent.putExtra("prenom",separe[0]);
                intent.putExtra("id",separe[2]);
                //Toast.makeText(this,"Bienvenue "+separe[0]+" "+separe[1],Toast.LENGTH_LONG).show();
                startActivity(intent);
            }else Toast.makeText(this,"MPD ou Matricule incorect",Toast.LENGTH_LONG).show();

        }catch (Exception e){
            Toast.makeText(this,"Erreur"+e.getLocalizedMessage(),Toast.LENGTH_LONG).show();
        }

    }
}

