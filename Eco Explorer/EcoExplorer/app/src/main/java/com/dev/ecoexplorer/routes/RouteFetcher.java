package com.dev.ecoexplorer.routes;

import android.os.AsyncTask;
import android.util.Log;

import com.google.android.gms.maps.model.LatLng;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.ArrayList;
import java.util.List;

public class RouteFetcher extends AsyncTask<Double, Void, RouteStep> {

    private static final String OPENROUTE_API_KEY = "5b3ce3597851110001cf62486aca080633114f06b3e3079b724b92f7";

    private OnRouteFetchedListener listener;

    public RouteFetcher(OnRouteFetchedListener listener) {
        this.listener = listener;
    }

    @Override
    protected RouteStep doInBackground(Double... params) {
        double startLat = params[0];
        double startLon = params[1];
        double endLat = params[2];
        double endLon = params[3];

        HttpURLConnection urlConnection = null;
        BufferedReader reader = null;
        RouteStep routeStep = new RouteStep();

        try {
            URL url = new URL("https://api.openrouteservice.org/v2/directions/driving-car?api_key=" +
                    OPENROUTE_API_KEY + "&start=" + startLon + "," + startLat + "&end=" + endLon + "," + endLat);

            urlConnection = (HttpURLConnection) url.openConnection();
            urlConnection.setRequestMethod("GET");

            StringBuilder result = new StringBuilder();
            reader = new BufferedReader(new InputStreamReader(urlConnection.getInputStream()));
            String line;
            while ((line = reader.readLine()) != null) {
                result.append(line);
            }

            JSONObject jsonResponse = new JSONObject(result.toString());
            Log.e("aaa", result.toString() );
            // Parse route paths for RecyclerView
            JSONArray routePaths = jsonResponse.getJSONArray("features");
            List<RoutePath> paths = new ArrayList<>();
            double totalDistance=0.0;
            double totalDuration=0.0;

            for (int i = 0; i < routePaths.length(); i++) {
                JSONObject feature = routePaths.getJSONObject(i);
                JSONArray segments = feature.getJSONObject("properties").getJSONArray("segments");
                for (int k = 0; k < segments.length(); k++) {
                    JSONObject segment = segments.getJSONObject(k);
                    JSONArray steps = segment.getJSONArray("steps");
                     totalDistance = segment.getDouble("distance");
                     totalDuration = segment.getDouble("duration");

                    for (int j = 0; j < steps.length(); j++) {
                        JSONObject step = steps.getJSONObject(j);
                        String instruction = step.getString("instruction");
                        double distance = step.getDouble("distance");
                        double duration = step.getDouble("duration");

                        RoutePath path = new RoutePath(instruction, distance, duration);
                        paths.add(path);
                    }
                }
            }
            routeStep.setPaths(paths);

            for (int i = 0; i < routePaths.length(); i++) {
                JSONObject feature = routePaths.getJSONObject(i);
                JSONObject geometry = feature.getJSONObject("geometry");
                JSONArray coordinatesArray = geometry.getJSONArray("coordinates");
                List<LatLng> coordinates = new ArrayList<>();
                for (int j = 0; j < coordinatesArray.length(); j++) {
                    JSONArray coordinate = coordinatesArray.getJSONArray(j); // Use j instead of i
                    double longitude = coordinate.getDouble(0);
                    double latitude = coordinate.getDouble(1);
                    coordinates.add(new LatLng(latitude, longitude));
                }
                routeStep.setTotalDistance(totalDistance);
                routeStep.setTotalDuration(totalDuration);
                routeStep.setPolyline(coordinates);
            }

        } catch (IOException | JSONException e) {
            listener.onRouteFetchError(e.getMessage());

            e.printStackTrace();
        } finally {
            if (urlConnection != null) {
                urlConnection.disconnect();
            }
            if (reader != null) {
                try {
                    reader.close();
                } catch (IOException e) {
                    e.printStackTrace();
                    listener.onRouteFetchError(e.getMessage());
                }
            }
        }

        return routeStep;
    }

    @Override
    protected void onPostExecute(RouteStep routeData) {
        super.onPostExecute(routeData);
        if (routeData != null) {
            listener.onRouteFetched(routeData);
        } else {
            // Handle error
            listener.onRouteFetchError("Failed to fetch route details.");
        }
    }

    public interface OnRouteFetchedListener {
        void onRouteFetched(RouteStep routeSteps);

        void onRouteFetchError(String errorMessage);
    }
}
