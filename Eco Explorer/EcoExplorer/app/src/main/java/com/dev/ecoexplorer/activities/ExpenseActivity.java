package com.dev.ecoexplorer.activities;

import android.app.DatePickerDialog;
import android.os.Build;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import com.dev.ecoexplorer.R;
import com.dev.ecoexplorer.db.DatabaseClient;
import com.dev.ecoexplorer.db.JourneyExpenseDao;
import com.dev.ecoexplorer.models.Helper;
import com.dev.ecoexplorer.models.JourneyExpense;

import java.util.Calendar;

public class ExpenseActivity extends AppCompatActivity {
    private TextView dateTextView;
    private DatePickerDialog datePickerDialog;
    private Spinner transportSpinner;
    private EditText cityNameEditText;
    private EditText amountEditText;
    private JourneyExpenseDao journeyExpenseDao;
    JourneyExpense journeyExpense;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_expense);

        dateTextView = findViewById(R.id.dateTextView);
        transportSpinner = findViewById(R.id.transportSpinner);
        cityNameEditText = findViewById(R.id.cityNameEditText);
        amountEditText = findViewById(R.id.amountEditText);
        Button addExpenseButton = findViewById(R.id.addExpenseButton);
        Button deleteExpense = findViewById(R.id.deleteBtn);

        journeyExpenseDao = DatabaseClient.getInstance(getApplicationContext())
                .getJourneyExpenseDatabase().journeyExpenseDao();
        journeyExpense = (JourneyExpense) getIntent().getSerializableExtra("data");

        ArrayAdapter<CharSequence> adapter = ArrayAdapter.createFromResource(this,
                R.array.expense_types, android.R.layout.simple_spinner_item);
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        transportSpinner.setAdapter(adapter);

        if (journeyExpense != null) {
            dateTextView.setText(journeyExpense.getDate());
            cityNameEditText.setText(journeyExpense.getCityName());
            amountEditText.setText(journeyExpense.getAmount() + "");
            int position=adapter.getPosition(journeyExpense.getTransportType());
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
                String cityName = cityNameEditText.getText().toString();
                double amount = Double.parseDouble(amountEditText.getText().toString());

                JourneyExpense journeyExpense = new JourneyExpense();
                journeyExpense.setUserId(String.valueOf(Helper.user.id));
                journeyExpense.setDate(date);
                journeyExpense.setTransportType(transportType);
                journeyExpense.setCityName(cityName);
                journeyExpense.setAmount(amount);
                if (ExpenseActivity.this.journeyExpense != null) {
                    journeyExpense.setId(ExpenseActivity.this.journeyExpense.getId());
                    journeyExpenseDao.update(journeyExpense);
                } else {
                    journeyExpenseDao.insert(journeyExpense);

                }
                finish();

            }
        });

        deleteExpense.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                journeyExpenseDao.delete(journeyExpense);
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
}