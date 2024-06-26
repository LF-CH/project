package com.dev.ecoexplorer.db;

import android.content.Context;

import androidx.room.Room;

public class DatabaseClient {

    private Context mCtx;
    private static DatabaseClient mInstance;

    //our app database object
    private AppDatabase journeyExpenseDatabase;

    private DatabaseClient(Context mCtx) {
        this.mCtx = mCtx;

        //creating the app database with Room database builder
        //JourneyExpenseDatabase is the name of the database
        journeyExpenseDatabase = Room.databaseBuilder(mCtx, AppDatabase.class, "JourneyExpenseDatabase").allowMainThreadQueries().build();
    }

    public static synchronized DatabaseClient getInstance(Context mCtx) {
        if (mInstance == null) {
            mInstance = new DatabaseClient(mCtx);
        }
        return mInstance;
    }

    public AppDatabase getJourneyExpenseDatabase() {
        return journeyExpenseDatabase;
    }
}

