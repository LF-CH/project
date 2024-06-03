package com.dev.ecoexplorer.activities;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.ListView;

import androidx.appcompat.app.AppCompatActivity;

import com.dev.ecoexplorer.R;
import com.dev.ecoexplorer.db.CarbonCalcDao;
import com.dev.ecoexplorer.db.DatabaseClient;
import com.dev.ecoexplorer.models.CarbonModel;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

import java.util.ArrayList;
import java.util.List;

public class CarbonCalculatorMainActivity extends AppCompatActivity {
    private FloatingActionButton btnAddExpense;
    private ListView listViewExpenses;
    private List<CarbonModel> carbonModelList;
    private ArrayAdapter<String> expensesAdapter;
    private CarbonCalcDao carbonCalcDao;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_carbon_calculator_main);

        btnAddExpense = findViewById(R.id.btnAdd);
        listViewExpenses = findViewById(R.id.listViewExpenses);
        carbonCalcDao = DatabaseClient.getInstance(getApplicationContext()).getJourneyExpenseDatabase().carbonCalcDao();

        carbonModelList = carbonCalcDao.getAllData();
        List<String> expenseStrings = new ArrayList<>();
        for (CarbonModel expense : carbonModelList) {
            expenseStrings.add(expense.getActivity() + " - $" + expense.getActivity() + " - " + expense.getDate());
        }

        expensesAdapter = new ArrayAdapter<>(this, android.R.layout.simple_list_item_1, expenseStrings);
        listViewExpenses.setAdapter(expensesAdapter);

        // Handle add expense button click
        btnAddExpense.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // Add your logic to open the add expense activity
                startActivity(new Intent(CarbonCalculatorMainActivity.this, CarbonCalculatorActivity.class));
            }
        });

        listViewExpenses.setOnItemClickListener((parent, view,
                                                 position, id) -> {
            // Add your logic to open the edit expense activity
            CarbonModel carbonModel = carbonModelList.get(position);
            Intent intent = new Intent(CarbonCalculatorMainActivity.this, CarbonCalculatorActivity.class);
            intent.putExtra("data", carbonModel);
            startActivity(intent);
        });

    }

    @Override
    protected void onResume() {
        super.onResume();
        carbonModelList = carbonCalcDao.getAllData();
        List<String> expenseStrings = new ArrayList<>();
        for (CarbonModel expense : carbonModelList) {
            expenseStrings.add(expense.getActivity() + " - $" + expense.getDistance() + " - " + expense.getDate());
        }
        expensesAdapter = new ArrayAdapter<>(this, android.R.layout.simple_list_item_1, expenseStrings);
        listViewExpenses.setAdapter(expensesAdapter);
    }
}