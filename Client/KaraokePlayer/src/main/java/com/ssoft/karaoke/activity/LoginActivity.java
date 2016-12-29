package com.ssoft.karaoke.activity;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.ssoft.karaoke.R;
import com.ssoft.karaoke.model.UserInfo;
import com.ssoft.karaoke.service.BasicService;
import com.ssoft.karaoke.service.RestApiCallBack;
import com.ssoft.karaoke.service.RestApiService;
import com.ssoft.karaoke.utils.Utils;

import org.json.JSONException;
import org.json.JSONObject;

/**
 * Created by luan.nt on 12/7/2016.
 */
public class LoginActivity extends Activity {
    private EditText edt_username, edt_password;
    private Button btn_login;
    private String s_user, s_pass;
    private ProgressDialog mProgressDialog, mProgressDialogVersion;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        autoLogin();

        edt_username = (EditText) findViewById(R.id.edt_username);
        edt_password = (EditText) findViewById(R.id.edt_password);

        btn_login = (Button) findViewById(R.id.btn_login);
        configProgress();
        configControlEvent();

    }

    void autoLogin() {
        SharedPreferences sharedPref = getSharedPreferences("data", MODE_PRIVATE);
        int number = sharedPref.getInt("isLogged", 0);
        if (number == 0) {

        } else {
            Intent intent = new Intent(LoginActivity.this, IntroActivity.class);
            startActivity(intent);
            finish();
        }
    }


    void configControlEvent() {
        btn_login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                SharedPreferences sharedPref = getSharedPreferences("data", MODE_PRIVATE);
                SharedPreferences.Editor prefEditor = sharedPref.edit();
                prefEditor.putInt("isLogged", 1);
                prefEditor.commit();
                mProgressDialog.show();
                onLoginClick();
            }
        });
    }

    void configProgress() {
        mProgressDialog = new ProgressDialog(LoginActivity.this);
        mProgressDialog.setMessage("Please waiting...");
        mProgressDialog.setIndeterminate(true);
        mProgressDialog.setProgressStyle(ProgressDialog.STYLE_SPINNER);
        mProgressDialog.setCancelable(true);
    }

    void onLoginClick() {
        if (Utils.isInternetAvailable(LoginActivity.this) == false) {
            Utils.showMessage(LoginActivity.this, getResources().getString(R.string.missconnect));
            return;
        }
        s_user = edt_username.getText().toString();
        s_pass = edt_password.getText().toString();

        if (s_user.equals("") || s_pass.equals("")) {
            Utils.showMessage(LoginActivity.this, getResources().getString(R.string.missing_content));
            return;
        }

        UserInfo user = new UserInfo();
        user.setUsername(s_user);
        user.setPassword(s_pass);

        RestApiService.Login(user, new RestApiCallBack() {
            @Override
            public void onSuccess(Boolean success, String response, Object object) {
                try {
                    JSONObject json = new JSONObject(response);
                    JSONObject ob = json.getJSONObject("data");
                    loginsuccess(ob);
                    Utils.showMessage(LoginActivity.this, json.getString("mess"));

                } catch (JSONException ex) {
                    mProgressDialog.dismiss();
                    ex.printStackTrace();
                    Utils.showMessage(LoginActivity.this, "Something error. Please try again!");
                }
            }

            @Override
            public void onFail(Boolean success, String error) {
                mProgressDialog.dismiss();
                Utils.showMessage(LoginActivity.this, error);
            }
        });
    }

    void loginsuccess(JSONObject data) {
        try {
            String s_ID = data.getString("id");
            String s_username = data.getString("username");
            String s_password = data.getString("password");
            String s_token = data.getString("token");

            UserInfo user = new UserInfo();
            user.setId(Integer.parseInt(s_ID));
            user.setUsername(s_username);
            user.setPassword(s_password);
            user.setToken(s_token);

            BasicService.getInstance().SaveAcc(user.getUsername(), user.getPassword(), user.getToken(), LoginActivity.this);
            BasicService.getInstance().currentUser = BasicService.getInstance().LoadAcc(LoginActivity.this);
            Intent intent = new Intent(LoginActivity.this, IntroActivity.class);
            startActivity(intent);
            finish();

        } catch (JSONException e) {
            e.printStackTrace();
            mProgressDialog.dismiss();
        }
    }

    @Override
    public void onBackPressed() {
        DialogInterface.OnClickListener dialogClickListener = new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                switch (which) {
                    case DialogInterface.BUTTON_POSITIVE:
                        LoginActivity.super.onBackPressed();
                        break;

                    case DialogInterface.BUTTON_NEGATIVE:
                        break;
                }
            }
        };

        AlertDialog.Builder builder = new AlertDialog.Builder(LoginActivity.this);
        builder.setMessage("Are you sure?").setPositiveButton("Yes", dialogClickListener)
                .setNegativeButton("No", dialogClickListener).show();

    }
}
