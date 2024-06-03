package com.dev.ecoexplorer;

import android.app.Activity;
import android.content.Context;
import android.location.Address;
import android.location.Geocoder;
import android.widget.Toast;

import com.google.android.gms.maps.model.LatLng;

import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.List;
import java.util.Locale;
import java.util.TimeZone;

public class Utils {
    Activity activity;
    public void init(Activity activity){
        this.activity=activity;
    }
    public static void toast(Activity activity,String msg){
        Toast.makeText(activity, msg, Toast.LENGTH_SHORT).show();
    }

    public static LatLng getLatLngFromAddress(Context context, String address) {
        Geocoder geocoder = new Geocoder(context);
        List<Address> addressList;
        LatLng latLng = null;

        try {
            addressList = geocoder.getFromLocationName(address, 1);
            if (addressList != null && addressList.size() > 0) {
                Address location = addressList.get(0);
                latLng = new LatLng(location.getLatitude(), location.getLongitude());
            }
        } catch (IOException e) {
            e.printStackTrace();
        }

        return latLng;
    }

    public static String getAddressFromLatLng(Context context, double latitude, double longitude) {
        Geocoder geocoder = new Geocoder(context, Locale.getDefault());
        String addressText = "";

        try {
            List<Address> addresses = geocoder.getFromLocation(latitude, longitude, 1);
            if (addresses != null && addresses.size() > 0) {
                Address address = addresses.get(0);
                addressText = address.getLocality() ; // Get the first line of address
            }
        } catch (IOException e) {
            e.printStackTrace();
        }

        return addressText;
    }

    public static String formatDistance(double totalDistance) {
        String distanceUnit;
        double convertedDistance;
        if (totalDistance < 1000) {
            distanceUnit = "meters";
            convertedDistance = totalDistance;
        } else {
            distanceUnit = "kilometers";
            convertedDistance = totalDistance / 1000; // Convert meters to kilometers
        }

        return String.format("%.2f %s", convertedDistance, distanceUnit);
    }
    public static String formatDuration(double totalDuration) {
        String durationUnit;
        double convertedDuration;

        if (totalDuration < 60) {
            durationUnit = "seconds";
            convertedDuration = totalDuration;
        } else if (totalDuration < 3600) {
            durationUnit = "minutes";
            convertedDuration = totalDuration / 60; // Convert seconds to minutes
        } else {
            durationUnit = "hours";
            convertedDuration = totalDuration / 3600; // Convert seconds to hours
        }

        return String.format("%.2f %s", convertedDuration, durationUnit);
    }

    public static String convertTime(long time) {
        Date date = new Date(time * 1000L);
        SimpleDateFormat timeFormatted = new SimpleDateFormat("HH:mm", Locale.UK);
        timeFormatted.setTimeZone(TimeZone.getDefault());
        return timeFormatted.format(date);
    }
    public static String getCurrentTime(long time) {
        Date date = new Date(time);
        SimpleDateFormat timeFormatted = new SimpleDateFormat("dd/MM/yyyy HH:mm:ss", Locale.UK);
        timeFormatted.setTimeZone(TimeZone.getDefault());
        return timeFormatted.format(date);
    }

}
