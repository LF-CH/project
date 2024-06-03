package com.dev.ecoexplorer.db;
// AppDatabase.java
import androidx.room.Database;
import androidx.room.RoomDatabase;

import com.dev.ecoexplorer.models.CarbonModel;
import com.dev.ecoexplorer.models.JourneyExpense;

@Database(entities = {User.class, JourneyExpense.class, CarbonModel.class}, version = 1)
public abstract class AppDatabase extends RoomDatabase {
    public abstract UserDao userDao();
    public abstract JourneyExpenseDao journeyExpenseDao();
    public abstract CarbonCalcDao carbonCalcDao();

}