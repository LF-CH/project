package com.dev.ecoexplorer.routes;

import com.google.android.gms.maps.model.LatLng;

import java.util.List;

public class RouteStep {
    private List<RoutePath> paths;
    private List<LatLng> polyline;

    private double totalDistance;
    private double totalDuration;

    public List<RoutePath> getPaths() {
        return paths;
    }

    public void setPaths(List<RoutePath> paths) {
        this.paths = paths;
    }

    public List<LatLng> getPolyline() {
        return polyline;
    }

    public void setPolyline(List<LatLng> polyline) {
        this.polyline = polyline;
    }

    public double getTotalDistance() {
        return totalDistance;
    }

    public void setTotalDistance(double totalDistance) {
        this.totalDistance = totalDistance;
    }

    public double getTotalDuration() {
        return totalDuration;
    }

    public void setTotalDuration(double totalDuration) {
        this.totalDuration = totalDuration;
    }
}

