package com.dev.ecoexplorer;

import android.os.Bundle;
import android.view.View;

import androidx.appcompat.app.AppCompatActivity;

import com.dev.ecoexplorer.databinding.ActivitySignUpBinding;
import com.dev.ecoexplorer.db.DatabaseClient;
import com.dev.ecoexplorer.db.User;
import com.dev.ecoexplorer.db.UserDao;

public class SignUpActivity extends AppCompatActivity {
    ActivitySignUpBinding binding;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        binding = ActivitySignUpBinding.inflate(getLayoutInflater());
        setContentView(binding.getRoot());

        binding.btnLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String email = binding.etEmail.getText().toString();
                String userName = binding.editTextUsername.getText().toString();
                String password = binding.editTextPassword.getText().toString();

                if (email.isEmpty()) {
                    Utils.toast(SignUpActivity.this, "Email is empty");
                    return;
                }
                if (userName.isEmpty()) {
                    Utils.toast(SignUpActivity.this, "User Name is empty");
                    return;
                }
                if (password.isEmpty()) {
                    Utils.toast(SignUpActivity.this, "Passwrod is empty");
                    return;
                }
                UserDao userDao = DatabaseClient.getInstance(SignUpActivity.this).getJourneyExpenseDatabase().userDao();
                User user = new User();
                user.setUsername(userName);
                user.setPassword(password);
                userDao.insertUser(user);
                finish();
            }
        });

    }
}