package com.dev.ecoexplorer.activities;

import android.app.DatePickerDialog;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import com.dev.ecoexplorer.R;
import com.dev.ecoexplorer.db.CarbonCalcDao;
import com.dev.ecoexplorer.db.DatabaseClient;
import com.dev.ecoexplorer.models.CarbonModel;

import java.util.Calendar;

public class CarbonCalculatorActivity extends AppCompatActivity {
    private TextView dateTextView;
    private DatePickerDialog datePickerDialog;
    private Spinner transportSpinner;
    private EditText distanceEditText;
    private EditText amountEditText;
    private CarbonCalcDao carbonCalcDao;
    CarbonModel carbonModel;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_carbon_calculator);

        dateTextView = findViewById(R.id.dateTextView);
        transportSpinner = findViewById(R.id.transportSpinner);
        distanceEditText = findViewById(R.id.distanceEditText);
        amountEditText = findViewById(R.id.amountEditText);
        Button addExpenseButton = findViewById(R.id.addExpenseButton);
        Button deleteExpense = findViewById(R.id.deleteBtn);
        carbonCalcDao = DatabaseClient.getInstance(getApplicationContext()).getJourneyExpenseDatabase().carbonCalcDao();
        carbonModel = (CarbonModel) getIntent().getSerializableExtra("data");

        ArrayAdapter<CharSequence> adapter = ArrayAdapter.createFromResource(this,
                R.array.transport_types, android.R.layout.simple_spinner_item);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        transportSpinner.setAdapter(adapter);

        if (carbonModel != null) {
            dateTextView.setText(carbonModel.getDate());
            distanceEditText.setText(carbonModel.getDistance());
            amountEditText.setText(carbonModel.getEmissionFactor());
            int position = adapter.getPosition(carbonModel.getActivity());
            transportSpinner.setSelection(position);
            deleteExpense.setVisibility(View.VISIBLE);
            addExpenseButton.setText("Update");
        }

        Calendar calendar = Calendar.getInstance();
        setDateInView(calendar.get(Calendar.YEAR), calendar.get(Calendar.MONTH),
                calendar.get(Calendar.DAY_OF_MONTH));

        // Initialize date picker dialog
        datePickerDialog = new DatePickerDialog(this,
                (view, year, monthOfYear, dayOfMonth) -> setDateInView(year, monthOfYear, dayOfMonth),
                calendar.get(Calendar.YEAR), calendar.get(Calendar.MONTH),
                calendar.get(Calendar.DAY_OF_MONTH));

        // Handle add expense button click
        addExpenseButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // Retrieve user input
                String date = dateTextView.getText().toString();
                String transportType = transportSpinner.getSelectedItem().toString();
                String distance = distanceEditText.getText().toString();
                double amount = Double.parseDouble(amountEditText.getText().toString());

                CarbonModel carbonModel = new CarbonModel();
                carbonModel.setDate(date);
                carbonModel.setActivity(transportType);
                carbonModel.setDistance(distance);
                carbonModel.setEmissionFactor(String.valueOf(amount));
                if (CarbonCalculatorActivity.this.carbonModel != null) {
                    carbonModel.setId(CarbonCalculatorActivity.this.carbonModel.getId());
                    carbonCalcDao.update(carbonModel);
                } else {
                    carbonCalcDao.insert(carbonModel);

                }

                double emissionRate = calculateCarbonEmissionRate(Double.parseDouble(distance), amount, transportType);
                String message =generateAdvice(emissionRate);
            }
        });

        deleteExpense.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                carbonCalcDao.delete(carbonModel);
                finish();
            }
        });
    }

    // Method to open date picker dialog
    public void openDatePickerDialog(View view) {
        datePickerDialog.show();
    }

    // Method to set selected date in date text view
    private void setDateInView(int year, int monthOfYear, int dayOfMonth) {
        dateTextView.setText(dayOfMonth + "/" + (monthOfYear + 1) + "/" + year);
    }

    public static double calculateCarbonEmissionRate(double distance, double emissionFactor, String vehicleType) {
        double vehicleFactor = getVehicleFactor(vehicleType);
        return distance * emissionFactor * vehicleFactor;
    }

    // Method to get vehicle factor based on vehicle type
    private static double getVehicleFactor(String vehicleType) {
        switch (vehicleType) {
            case "Car":
                return 1.0; // Standard emission factor for cars
            case "Bus":
                return 1.2; // Example: Higher emission factor for buses compared to cars
            case "Bicycle":
                return 0;
            case "Train":
                return 1.8;
            case "Plane":
                return 2.0;
                // Example: Lower emission factor for bikes compared to cars
            default:
                return 1.0; // Default to standard emission factor
        }
    }

    // Method to generate advice based on carbon emission rate
    public static String generateAdvice(double carbonEmissionRate) {
        if (carbonEmissionRate <= 50) {
            return "Your carbon footprint is low. Keep up the good work!";
        } else if (carbonEmissionRate <= 100) {
            return "Your carbon footprint is moderate. Consider reducing your emissions further.";
        } else {
            return "Your carbon footprint is high. Take immediate actions to reduce your emissions.";
        }
    }


}

