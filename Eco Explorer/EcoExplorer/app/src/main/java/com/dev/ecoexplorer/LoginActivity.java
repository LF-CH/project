package com.dev.ecoexplorer;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;

import androidx.appcompat.app.AppCompatActivity;

import com.dev.ecoexplorer.databinding.ActivityLoginBinding;
import com.dev.ecoexplorer.db.DatabaseClient;
import com.dev.ecoexplorer.db.User;
import com.dev.ecoexplorer.db.UserDao;
import com.dev.ecoexplorer.models.Helper;

public class LoginActivity extends AppCompatActivity {
    ActivityLoginBinding binding;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        binding = ActivityLoginBinding.inflate(getLayoutInflater());
        setContentView(binding.getRoot());

        binding.btnLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String userName = binding.editTextUsername.getText().toString();
                String password = binding.editTextPassword.getText().toString();

                if (userName.isEmpty()) {
                    Utils.toast(LoginActivity.this, "User Name is empty");
                    return;
                }
                if (password.isEmpty()) {
                    Utils.toast(LoginActivity.this, "Password is empty");
                    return;
                }
                UserDao userDao = DatabaseClient.getInstance(LoginActivity.this).getJourneyExpenseDatabase().userDao();
                User user = userDao.login(userName, password);
                if (user != null) {
                    Helper.user = user;
                    startActivity(new Intent(LoginActivity.this, MainActivity.class));
                    finish();
                } else {
                    Utils.toast(LoginActivity.this, "Incorrect user or Password");
                }
            }
        });
        binding.textViewSignUp.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(LoginActivity.this,SignUpActivity.class));
            }
        });
    }
}