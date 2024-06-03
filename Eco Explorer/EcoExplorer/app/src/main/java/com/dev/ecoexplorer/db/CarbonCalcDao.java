package com.dev.ecoexplorer.db;

import androidx.room.Dao;
import androidx.room.Delete;
import androidx.room.Insert;
import androidx.room.Query;
import androidx.room.Update;

import com.dev.ecoexplorer.models.CarbonModel;
import com.dev.ecoexplorer.models.JourneyExpense;

import java.util.List;

@Dao
public interface CarbonCalcDao {

    @Insert
    void insert(CarbonModel carbonModel);

    @Query("SELECT * FROM carbon_calculator")
    List<CarbonModel> getAllData();

    @Query("SELECT * FROM carbon_calculator WHERE userId = :userId")
    List<CarbonModel> getExpensesByUserId(int userId);

    @Delete
    void delete(CarbonModel carbonModel);

    @Update
    void update(CarbonModel carbonModel);

    // Get weekly summary
    @Query("SELECT SUM(emissionFactor) FROM carbon_calculator WHERE strftime('%Y-%W', date) = strftime('%Y-%W', 'now')")
    float getWeeklySummary();

    // Get monthly summary
    @Query("SELECT SUM(emissionFactor) FROM carbon_calculator WHERE strftime('%Y-%m', date) = strftime('%Y-%m', 'now')")
    float getMonthlySummary();

    // Get 6-month summary
    @Query("SELECT SUM(emissionFactor) FROM carbon_calculator WHERE date >= date('now', '-6 months')")
    float getSixMonthSummary();

    // You can also have methods to get detailed data for each period if needed
    @Query("SELECT * FROM carbon_calculator WHERE strftime('%Y-%W', date) = strftime('%Y-%W', 'now')")
    List<CarbonModel> getWeeklyData();

    @Query("SELECT * FROM carbon_calculator WHERE strftime('%Y-%m', date) = strftime('%Y-%m', 'now')")
    List<CarbonModel> getMonthlyData();

    @Query("SELECT * FROM carbon_calculator WHERE date >= date('now', '-6 months')")
    List<CarbonModel> getSixMonthData();
}
