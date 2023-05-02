package com.example.epoka_tm;

import android.app.Activity;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;


import androidx.loader.content.AsyncTaskLoader;

import org.json.JSONArray;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;


public class MissionActivity extends Activity {


    String url = "http://172.16.47.26/epoka/ServiceWeb/Communes";
    Spinner SPVilles;
    EditText ETDateDebut;
    EditText ETDateFin;
    TextView TxtIntro;
    EditText EtNomMission;



    ArrayList<Liste_Communes> list = new ArrayList<Liste_Communes>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_missions);

        Bundle extras =getIntent().getExtras();
        String nom=extras.getString("nom");
        String prenom=extras.getString("prenom");



        SPVilles = findViewById(R.id.SPVilles);
        ETDateDebut = findViewById(R.id.ETDateDebut);
        ETDateFin = findViewById(R.id.ETDateFin);
        TxtIntro = findViewById(R.id.txtBienvenue);


        TxtIntro.setText("Bienvenue "+prenom+" "+nom);

        TacheAsychrones tacheAsychrone = new TacheAsychrones();
        tacheAsychrone.execute();
    }

    public void ajouter(View view){
        Bundle extras =getIntent().getExtras();
        ETDateDebut = findViewById(R.id.ETDateDebut);
        ETDateFin = findViewById(R.id.ETDateFin);
        EtNomMission = findViewById(R.id.ETNomMission);
        SPVilles = findViewById(R.id.SPVilles);
        Liste_Communes ville =(Liste_Communes)SPVilles.getSelectedItem();

        int commune =ville.id;
        String debut = ETDateDebut.getText().toString();
        String fin = ETDateFin.getText().toString();
        String nom = EtNomMission.getText().toString();
        String id=extras.getString("id");
        String url2 = "http://172.16.47.26/epoka/ServiceWeb/ajoutermission?depart="+debut+"&fin="+fin+"&lieu="+commune+"&intitule="+nom+"&matricule="+id;


        try{
            String ch="";
            InputStream is = null;

            URL url = new URL(url2);
            HttpURLConnection connexion =(HttpURLConnection)url.openConnection();
            connexion.connect();

            is=connexion.getInputStream();


            BufferedReader br =new BufferedReader(new InputStreamReader(is));
            String ligne;

            while ((ligne=br.readLine())!=null){
                ch= ch + ligne+"\n";
            };
            Toast.makeText(MissionActivity.this,ch,Toast.LENGTH_LONG).show();

        }catch (Exception e){
            Toast.makeText(MissionActivity.this,"Erreur recup données "+e.getLocalizedMessage(),Toast.LENGTH_LONG).show();
        }

    }



    private class TacheAsychrones extends AsyncTask<Void,Integer,String> {


        @Override
        protected String doInBackground(Void... voids){
            return (getServerDataJSON(url));

        }
        @Override
        protected void onPostExecute(String ch){


            ArrayAdapter<Liste_Communes> adapter=new ArrayAdapter<Liste_Communes>(MissionActivity.this, android.R.layout.simple_spinner_item, list);
            SPVilles.setAdapter(adapter);
        }


        private String getServerDataJSON(String urlString){

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
                    ch= ch + ligne+"\n";
                };

            }catch (Exception e){
                Toast.makeText(MissionActivity.this,"Erreur recup données "+e.getLocalizedMessage(),Toast.LENGTH_LONG).show();
            }

            try{
                JSONArray jArray =new JSONArray(ch);

                for (int i=0;i< jArray.length();i++){
                    JSONObject jsonData = jArray.getJSONObject(i);
                    list.add(new Liste_Communes(jsonData.getString("comNom"),jsonData.getInt("comID"),jsonData.getString("comCP")));


                }

            }catch (Exception e){
                Toast.makeText(MissionActivity.this,"Erreur décodage "+e.getLocalizedMessage(),Toast.LENGTH_LONG).show();
            }
            return ch;
        }
        }
}
