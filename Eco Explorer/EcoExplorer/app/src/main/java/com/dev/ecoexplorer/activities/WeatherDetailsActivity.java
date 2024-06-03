package com.dev.ecoexplorer.activities;

import android.app.ProgressDialog;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.SearchView;

import com.dev.ecoexplorer.Utils;
import com.dev.ecoexplorer.databinding.ActivityWeatherDetailsBinding;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.text.SimpleDateFormat;
import java.util.Date;

public class WeatherDetailsActivity extends AppCompatActivity {

    private ActivityWeatherDetailsBinding binding;
    String address="";
    ProgressDialog progressDialog;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        binding = ActivityWeatherDetailsBinding.inflate(getLayoutInflater());
        setContentView(binding.getRoot());
        progressDialog=new ProgressDialog(this);
        progressDialog.setCancelable(false);
        progressDialog.setTitle("Fetching Weather");
        address=getIntent().getStringExtra("address");
        if (!address.isEmpty()){
            getWeather(address);
        }
        binding.etSearch.setOnQueryTextListener(new SearchView.OnQueryTextListener() {
            @Override
            public boolean onQueryTextSubmit(String query) {
                getWeather(query);
                return false;
            }

            @Override
            public boolean onQueryTextChange(String newText) {
                return false;
            }
        });
    }

    // Function to fetch weather data
    private void getWeather(String city) {
        binding.textViewAddress.setText(city);
        binding.textViewUpdatedAt.setText(Utils.getCurrentTime(System.currentTimeMillis()));
        // Replace 'YOUR_API_KEY' with your actual OpenWeather API key
        String apiKey = "cbf26d51498f81728fd1bb69df49fa59";
        String url = "https://api.openweathermap.org/data/2.5/weather?q=" + city + "&appid=" + apiKey;

        // Execute AsyncTask to fetch weather data
        new FetchWeatherTask().execute(url);
    }

    // AsyncTask to fetch weather data from OpenWeather API
    private class FetchWeatherTask extends AsyncTask<String, Void, String> {
        @Override
        protected void onPreExecute() {
            progressDialog.show();
            super.onPreExecute();
        }

        @Override
        protected String doInBackground(String... urls) {
            try {
                URL url = new URL(urls[0]);
                HttpURLConnection connection = (HttpURLConnection) url.openConnection();
                connection.setRequestMethod("GET");

                BufferedReader reader = new BufferedReader(new InputStreamReader(connection.getInputStream()));
                StringBuilder response = new StringBuilder();
                String line;
                while ((line = reader.readLine()) != null) {
                    response.append(line);
                }
                reader.close();
                return response.toString();
            } catch (IOException e) {
                e.printStackTrace();
                return null;
            }
        }

        @Override
        protected void onPostExecute(String result) {
            progressDialog.dismiss();
            if (result != null) {
                try {
                    // Parse JSON response
                    JSONObject jsonObject = new JSONObject(result);

                    // Sunrise and Sunset
                    Log.e("aaa", "onPostExecute: "+jsonObject.toString() );
                    JSONObject sysObject = jsonObject.getJSONObject("sys");
                    long sunriseTimestamp = sysObject.getLong("sunrise");
                    long sunsetTimestamp = sysObject.getLong("sunset");
                    // Convert timestamps to readable time format if needed
                    JSONObject weatherObject = jsonObject.getJSONArray("weather").getJSONObject(0);

                    // Extracting "main" and "description"
                    String main = weatherObject.getString("main");
                    String description = weatherObject.getString("description");
                    // Wind Speed
                    JSONObject windObject = jsonObject.getJSONObject("wind");
                    double windSpeed = windObject.getDouble("speed");

                    // Pressure
                    double pressure = jsonObject.getJSONObject("main").getDouble("pressure");

                    // Humidity
                    int humidity = jsonObject.getJSONObject("main").getInt("humidity");

                    // Clouds Percentage
                    JSONObject cloudsObject = jsonObject.getJSONObject("clouds");
                    int cloudsPercentage = cloudsObject.getInt("all");

                    // Max Temperature
                    double maxTemperature = jsonObject.getJSONObject("main").getDouble("temp_max") - 273.15; // Convert from Kelvin to Celsius

                    // Min Temperature
                    double minTemperature = jsonObject.getJSONObject("main").getDouble("temp_min") - 273.15; // Convert from Kelvin to Celsius

                    // Current Temperature
                    double currentTemperature = jsonObject.getJSONObject("main").getDouble("temp") - 273.15; // Convert from Kelvin to Celsius
                    binding.textViewUpdatedAt.
                            setText(new SimpleDateFormat("dd/MM/yyyy hh:mm:ss")
                                    .format(new Date(System.currentTimeMillis())));
                    binding.textViewTemp.setText((int) currentTemperature + "°C");
                    binding.textViewTempMax.setText("Max Temp:"+(int)maxTemperature + "°C");
                    binding.textViewTempMin.setText("Min Temp:"+(int)minTemperature + "°C");
                    binding.textViewSunrise.setText(""+Utils.convertTime(sunriseTimestamp));
                    binding.textViewSunset.setText(Utils.convertTime(sunsetTimestamp));
                    binding.textViewWind.setText((int)windSpeed + " km/h");
                    binding.textViewPressure.setText((int)pressure + " ");
                    binding.textViewHumidity.setText((int)humidity + " ");
                    binding.textViewClouds.setText((int)cloudsPercentage + "%");
                    binding.textViewStatus.setText(main);

                } catch (JSONException e) {
                    e.printStackTrace();
                    // Handle JSON parsing error
                }
            } else {
                // Handle error
            }
        }

    }
}