package com.dev.ecoexplorer.routes;

import android.os.AsyncTask;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import org.osmdroid.util.GeoPoint;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;

public class SearchTask extends AsyncTask<String, Void, GeoPoint> {

    private static final String NOMINATIM_API_URL = "https://nominatim.openstreetmap.org/search";
    private static final String FORMAT_JSON = "&format=json";

    private OnSearchResultListener listener;

    public SearchTask(OnSearchResultListener listener) {
        this.listener = listener;
    }

    @Override
    protected GeoPoint doInBackground(String... params) {
        String searchQuery = params[0];
        GeoPoint result = null;

        try {
            // Encode search query for URL
            String encodedQuery = URLEncoder.encode(searchQuery, "UTF-8");

            // Construct URL for Nominatim API request
            String urlString = NOMINATIM_API_URL + "?q=" + encodedQuery + FORMAT_JSON;

            URL url = new URL(urlString);
            HttpURLConnection urlConnection = (HttpURLConnection) url.openConnection();
            urlConnection.setRequestMethod("GET");

            BufferedReader reader = new BufferedReader(new InputStreamReader(urlConnection.getInputStream()));
            StringBuilder response = new StringBuilder();
            String line;
            while ((line = reader.readLine()) != null) {
                response.append(line);
            }
            reader.close();

            // Parse JSON response
            JSONArray jsonArray = new JSONArray(response.toString());
            if (jsonArray.length() > 0) {
                JSONObject jsonResult = jsonArray.getJSONObject(0);
                double lat = jsonResult.getDouble("lat");
                double lon = jsonResult.getDouble("lon");
                result = new GeoPoint(lat, lon);
            }
        } catch (JSONException e) {
            throw new RuntimeException(e);
        } catch (IOException e) {
            e.printStackTrace();
        }

        return result;
    }

    @Override
    protected void onPostExecute(GeoPoint geoPoint) {
        super.onPostExecute(geoPoint);
        if (geoPoint != null) {
            listener.onSearchResult(geoPoint);
        } else {
            listener.onSearchError("Location not found");
        }
    }

    public interface OnSearchResultListener {
        void onSearchResult(GeoPoint geoPoint);
        void onSearchError(String errorMessage);
    }
}
