package com.dev.ecoexplorer;

import android.Manifest;
import android.annotation.SuppressLint;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.KeyEvent;
import android.view.View;
import android.view.inputmethod.EditorInfo;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.LinearLayoutManager;

import com.dev.ecoexplorer.activities.CarbonCalculatorMainActivity;
import com.dev.ecoexplorer.activities.ExpenseTrackerActivity;
import com.dev.ecoexplorer.activities.WeatherDetailsActivity;
import com.dev.ecoexplorer.adapters.HomeAdapter;
import com.dev.ecoexplorer.adapters.StepsAdapter;
import com.dev.ecoexplorer.databinding.ActivityMainBinding;
import com.dev.ecoexplorer.routes.RouteFetcher;
import com.dev.ecoexplorer.routes.RoutePath;
import com.dev.ecoexplorer.routes.RouteStep;
import com.dev.ecoexplorer.routes.SearchTask;
import com.google.android.gms.location.FusedLocationProviderClient;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.tasks.OnCompleteListener;
import com.google.android.gms.tasks.Task;

import org.osmdroid.api.IMapController;
import org.osmdroid.config.Configuration;
import org.osmdroid.util.GeoPoint;
import org.osmdroid.views.MapView;
import org.osmdroid.views.overlay.Marker;
import org.osmdroid.views.overlay.Polyline;
import org.osmdroid.views.overlay.mylocation.GpsMyLocationProvider;
import org.osmdroid.views.overlay.mylocation.MyLocationNewOverlay;

import java.util.ArrayList;
import java.util.List;

public class MainActivity extends AppCompatActivity implements LocationListener, SearchTask.OnSearchResultListener {

    private static final int REQUEST_PERMISSIONS_REQUEST_CODE = 1;

    private MapView mapView;
    ActivityMainBinding binding;
    boolean isFindingRoutes;
    private StepsAdapter adapter;
    private List<RoutePath> list = new ArrayList<>();
    String address = "";
    GeoPoint currentLocation;
    private FusedLocationProviderClient fusedLocationProviderClient;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        // Initialize osmdroid configuration
        Configuration.getInstance().load(getApplicationContext(), getSharedPreferences("osmdroid", MODE_PRIVATE));
        binding = ActivityMainBinding.inflate(getLayoutInflater());
        setContentView(binding.getRoot());

        mapView = binding.map;
        mapView.setBuiltInZoomControls(true);
        mapView.setMultiTouchControls(true);
        fusedLocationProviderClient= LocationServices.getFusedLocationProviderClient(this);
        setAdapter();
        setSearch();
        resetViews();
        listeners();
        // Check and request permissions
        if (ContextCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION) != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, REQUEST_PERMISSIONS_REQUEST_CODE);
        } else {
            setupMap();
            fusedLocationProviderClient.getLastLocation().addOnCompleteListener(new OnCompleteListener<Location>() {
                @Override
                public void onComplete(@NonNull Task<Location> task) {
                    Location location=task.getResult();
                 address=Utils.getAddressFromLatLng(MainActivity.this,location.getLatitude(),location.getLongitude());
                }
            });
        }
    }

    private void setupMap() {
        // Create a location overlay
        MyLocationNewOverlay myLocationOverlay = new MyLocationNewOverlay(new GpsMyLocationProvider(this), mapView);
        myLocationOverlay.enableMyLocation(new GpsMyLocationProvider(this));

        // Add the location overlay to the map
        mapView.getOverlays().add(myLocationOverlay);

        // Set the default zoom level and center
        mapView.getController().setZoom(15);

        // Get the current location
        currentLocation = myLocationOverlay.getMyLocation();
        myLocationOverlay.runOnFirstFix(new Runnable() {
            @Override
            public void run() {
                runOnUiThread(new Runnable() {
                    @Override
                    public void run() {
                        if (currentLocation != null) {
                            // Zoom the camera to the current location
                            mapView.getController().animateTo(currentLocation);

                            // Create a marker at the current location
                            Marker marker = new Marker(mapView);
                            marker.setPosition(currentLocation);
                            mapView.getOverlays().add(marker);

                        }
                    }
                });
            }
        });

        myLocationOverlay.enableFollowLocation();
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
        if (requestCode == REQUEST_PERMISSIONS_REQUEST_CODE) {
            if (grantResults.length > 0 && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                setupMap();
            } else {
                Toast.makeText(this, "Permission denied. Cannot show location.", Toast.LENGTH_SHORT).show();
            }
        }
    }

    @Override
    public void onLocationChanged(@NonNull Location location) {
        Log.e("aaa", "onLocationChanged: ");
        if (location != null) {
            double latitude = location.getLatitude();
            double longitude = location.getLongitude();
            address = Utils.getAddressFromLatLng(MainActivity.this, latitude, longitude);
            // Update map or UI with the new location
            GeoPoint currentLocation = new GeoPoint(latitude, longitude);
            mapView.getController().animateTo(currentLocation);
            // You can also update the marker's position here if neede
        }
    }

    private void setAdapter() {
        binding.rvItems.setLayoutManager(new GridLayoutManager(MainActivity.this, 2));

        HomeAdapter adapter = new HomeAdapter(pos -> {
            switch (pos) {
                case 0:
                    setRoutes();
                    break;
                case 1:

                    Intent intent = new Intent(MainActivity.this, WeatherDetailsActivity.class);
                    intent.putExtra("address", address);
                    startActivity(intent);
                    break;
                case 2:
                    startActivity(new Intent(MainActivity.this, ExpenseTrackerActivity.class));
                    break;
                case 3:
                    startActivity(new Intent(MainActivity.this, CarbonCalculatorMainActivity.class));
                    break;


            }
        });
        binding.rvItems.setAdapter(adapter);
    }

    private void setSteps(RouteStep routeSteps) {
        binding.tvDistance.setVisibility(View.VISIBLE);
        binding.tvTime.setVisibility(View.VISIBLE);
        binding.tvDistance.setText(Utils.formatDistance(routeSteps.getTotalDistance()));
        binding.tvTime.setText(Utils.formatDuration(routeSteps.getTotalDuration()));
        binding.rvItems.setLayoutManager(new LinearLayoutManager(MainActivity.this));
        adapter = new StepsAdapter(list, this);
        binding.rvItems.setAdapter(adapter);
        binding.llBottom.setVisibility(View.VISIBLE);

    }

    private void listeners() {
        binding.etEnd.setOnEditorActionListener(new TextView.OnEditorActionListener() {
            @Override
            public boolean onEditorAction(TextView v, int actionId, KeyEvent event) {
                if (actionId == EditorInfo.IME_ACTION_DONE) {
                    // Action Next pressed
                    String start = binding.etStart.getText().toString();
                    String end = binding.etEnd.getText().toString();
                    RouteFetcher fetcher = new RouteFetcher(new RouteFetcher.OnRouteFetchedListener() {
                        @Override
                        public void onRouteFetched(RouteStep routeSteps) {

                            List<LatLng> polyline = routeSteps.getPolyline();
                            List<GeoPoint> points = new ArrayList<>();
                            Polyline line = new Polyline();
                            for (LatLng latLng : polyline) {
                                GeoPoint geoPoint = new GeoPoint(latLng.latitude, latLng.longitude);
                                points.add(geoPoint);
                            }

                            line.setPoints(points);
                            mapView.getOverlayManager().add(line);
                            mapView.getController().animateTo(points.get(0));
                            mapView.invalidate(); // Refresh the map view

                            list.clear();
                            list.addAll(routeSteps.getPaths());
                            setSteps(routeSteps);
                            adapter.notifyDataSetChanged();

                        }

                        @Override
                        public void onRouteFetchError(String errorMessage) {

                        }
                    });

                    LatLng startLocation = Utils.getLatLngFromAddress(MainActivity.this, start);
                    LatLng endLocation = Utils.getLatLngFromAddress(MainActivity.this, end);
                    if (startLocation != null && endLocation != null) {
                        fetcher.execute(startLocation.latitude, startLocation.longitude, endLocation.latitude, endLocation.longitude);
                    } else {
                        Toast.makeText(MainActivity.this, "Location Not Fetched", Toast.LENGTH_SHORT).show();
                    }
                    return true; // Return true to consume the event
                }
                return false; // Return false to let the event propagate
            }
        });
    }

    private void setRoutes() {
        isFindingRoutes = true;
        binding.reRouteGroup.setVisibility(View.VISIBLE);
        binding.orignialGroup.setVisibility(View.GONE);

    }

    private void resetViews() {
        binding.reRouteGroup.setVisibility(View.GONE);
        binding.orignialGroup.setVisibility(View.VISIBLE);
        setAdapter();
        binding.tvDistance.setVisibility(View.GONE);
        binding.tvTime.setVisibility(View.GONE);
    }

    @SuppressLint("MissingSuperCall")
    @Override
    public void onBackPressed() {
        if (isFindingRoutes) {
            isFindingRoutes = !isFindingRoutes;
            resetViews();
        } else {
            finish();
        }
    }

    private void setSearch() {
        binding.etSearch.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {

            }

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {

            }

            @Override
            public void afterTextChanged(Editable s) {
                String query = s.toString();
                if (query.isEmpty()) {
                    return;
                }
                searchLocation(query);
            }
        });
    }

    private void searchLocation(String query) {
        SearchTask searchTask = new SearchTask(MainActivity.this);
        searchTask.execute(query);
    }

    @Override
    public void onSearchResult(GeoPoint geoPoint) {
        IMapController mapController = mapView.getController();
        mapController.animateTo(geoPoint);

        Marker marker = new Marker(mapView);
        marker.setPosition(geoPoint);
        mapView.getOverlays().add(marker);
        mapView.invalidate(); // Refresh map
    }

    @Override
    public void onSearchError(String errorMessage) {
        Toast.makeText(this, errorMessage, Toast.LENGTH_SHORT).show();

    }
}

