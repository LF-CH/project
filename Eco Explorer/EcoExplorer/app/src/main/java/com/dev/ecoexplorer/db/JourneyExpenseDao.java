package com.dev.ecoexplorer.db;


import androidx.room.Dao;
import androidx.room.Delete;
import androidx.room.Insert;
import androidx.room.Query;
import androidx.room.Update;

import com.dev.ecoexplorer.models.JourneyExpense;

import java.util.List;

@Dao
public interface JourneyExpenseDao {

    @Insert
    void insert(JourneyExpense journeyExpense);

    @Query("SELECT * FROM journey_expenses")
    List<JourneyExpense> getAllJourneyExpenses();


    @Query("SELECT * FROM journey_expenses WHERE userId = :userId")
    List<JourneyExpense> getExpensesByUserId(int userId);

    @Delete
    void delete(JourneyExpense journeyExpense);

    @Update
    void update(JourneyExpense journeyExpense);
}