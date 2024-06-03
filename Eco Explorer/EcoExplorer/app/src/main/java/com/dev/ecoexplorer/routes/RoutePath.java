package com.dev.ecoexplorer.routes;

import androidx.annotation.NonNull;

public class RoutePath {
    private String instruction;
    private double distance;
    private double duration;

    public RoutePath(String instruction, double distance, double duration) {
        this.instruction = instruction;
        this.distance = distance;
        this.duration = duration;
    }

    public String getInstruction() {
        return instruction;
    }

    public void setInstruction(String instruction) {
        this.instruction = instruction;
    }

    public double getDistance() {
        return distance;
    }

    public void setDistance(double distance) {
        this.distance = distance;
    }

    public double getDuration() {
        return duration;
    }

    public void setDuration(double duration) {
        this.duration = duration;
    }

    @NonNull
    @Override
    public String toString() {
        return instruction+" :"+ distance+" :"+duration;
    }
}
