package com.dev.ecoexplorer.models;

import androidx.room.Entity;
import androidx.room.PrimaryKey;

import java.io.Serializable;

@Entity(tableName = "carbon_calculator")
public class CarbonModel implements Serializable {

    @PrimaryKey(autoGenerate = true)
    private int id;
    private String date;
    private int userId=0;

    private String activity;
    private String distance;

    private String emissionFactor;

    public int getUserId() {
        return userId;
    }

    public void setUserId(int userId) {
        this.userId = userId;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public String getActivity() {
        return activity;
    }

    public void setActivity(String activity) {
        this.activity = activity;
    }

    public String getDistance() {
        return distance;
    }

    public void setDistance(String distance) {
        this.distance = distance;
    }

    public String getEmissionFactor() {
        return emissionFactor;
    }

    public void setEmissionFactor(String emissionFactor) {
        this.emissionFactor = emissionFactor;
    }
}
