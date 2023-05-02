package com.example.epoka_tm;

public class Liste_Communes {
    public String nom;
    public  int id;
    public String CP;

    public Liste_Communes(String unNom , int unId , String unCP){
        nom = unNom;
        id = unId;
        CP = unCP;
    }

    @Override
    public String toString(){
        return nom+" ("+CP+")";
    }

}
