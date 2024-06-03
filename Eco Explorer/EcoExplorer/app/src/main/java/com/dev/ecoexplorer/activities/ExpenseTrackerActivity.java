package com.dev.ecoexplorer.activities;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.dev.ecoexplorer.R;
import com.dev.ecoexplorer.db.DatabaseClient;
import com.dev.ecoexplorer.db.JourneyExpenseDao;
import com.dev.ecoexplorer.models.Helper;
import com.dev.ecoexplorer.models.JourneyExpense;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

import java.util.ArrayList;
import java.util.List;

public class ExpenseTrackerActivity extends AppCompatActivity {
    private TextView textHeader;
    private FloatingActionButton btnAddExpense;
    private ListView listViewExpenses;

    private List<JourneyExpense> expensesList;
    private ArrayAdapter<String> expensesAdapter;

    private JourneyExpenseDao journeyExpenseDao;

    public ExpenseTrackerActivity() {
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_expense_tracker2);
        btnAddExpense = findViewById(R.id.btnAdd);
        listViewExpenses = findViewById(R.id.listViewExpenses);
        journeyExpenseDao = DatabaseClient.getInstance(getApplicationContext()).getJourneyExpenseDatabase().journeyExpenseDao();

        expensesList = journeyExpenseDao.getExpensesByUserId(Helper.user.id);
        List<String> expenseStrings = new ArrayList<>();
        for (JourneyExpense expense : expensesList) {
            expenseStrings.add(expense.getTransportType() + " - $" + expense.getAmount() + " - " + expense.getDate());
        }
        expensesAdapter = new ArrayAdapter<>(this, android.R.layout.simple_list_item_1, expenseStrings);
        listViewExpenses.setAdapter(expensesAdapter);

        // Handle add expense button click
        btnAddExpense.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // Add your logic to open the add expense activity
                startActivity(new Intent(ExpenseTrackerActivity.this,ExpenseActivity.class));
            }
        });

        listViewExpenses.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                // Add your logic to open the edit expense activity
                JourneyExpense expense=expensesList.get(position);
                Intent intent=new Intent(ExpenseTrackerActivity.this,ExpenseActivity.class);
                intent.putExtra("data",expense);
                startActivity(intent);
            }
        });

    }

    @Override
    protected void onResume() {
        super.onResume();
        expensesList = journeyExpenseDao.getExpensesByUserId(Helper.user.id);
        List<String> expenseStrings = new ArrayList<>();
        for (JourneyExpense expense : expensesList) {
            expenseStrings.add(expense.getTransportType() + " - $" + expense.getAmount() + " - " + expense.getDate());
        }
        expensesAdapter = new ArrayAdapter<>(this, android.R.layout.simple_list_item_1, expenseStrings);
        listViewExpenses.setAdapter(expensesAdapter);
    }
}