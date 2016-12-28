package com.ssoft.karaoke.activity;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;
import android.net.Uri;
import android.os.Bundle;
import android.view.MotionEvent;
import android.view.View;
import android.webkit.MimeTypeMap;
import android.widget.Button;

import com.ssoft.karaoke.R;
import com.ssoft.karaoke.model.Song;
import com.ssoft.karaoke.model.UserInfo;
import com.ssoft.karaoke.service.BasicService;
import com.ssoft.karaoke.service.DownloadRestore;
import com.ssoft.karaoke.service.DownloadVersion;
import com.ssoft.karaoke.service.RestApiCallBack;
import com.ssoft.karaoke.service.RestApiService;
import com.ssoft.karaoke.utils.Utils;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.File;
import java.util.ArrayList;

public class IntroActivity extends Activity {

    private Button bt_godownload, bt_update, bt_downloadmenu;
    ProgressDialog mProgressDialog, mProgressDialogSong;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_intro);

        bt_godownload = (Button) findViewById(R.id.btn_godownload);
        bt_downloadmenu = (Button) findViewById(R.id.btn_downloadmenu);
        bt_update = (Button) findViewById(R.id.btn_update);
        configProgress();
        configProgressSong();
        checkVersion();
        configControlEvent();
    }

    void configControlEvent() {
        bt_godownload.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                UserInfo user = BasicService.getInstance().LoadAcc(IntroActivity.this);
                BasicService.getInstance().SongRequest = new ArrayList<Song>();
                String[] neededPermission = Utils.getMissingPermission(IntroActivity.this);
                if (neededPermission.length > 0) {
                    pleaseSetPermission();
                    return;
                }
                if (Utils.isInternetAvailable(IntroActivity.this) == false) {
                    Utils.showMessage(IntroActivity.this, getResources().getString(R.string.missconnect));
                    return;
                }
                if (user != null) {
                    mProgressDialogSong.show();
                    downloaddata(user);
                }
            }
        });

        bt_godownload.setOnHoverListener(new View.OnHoverListener() {
            @Override
            public boolean onHover(View view, MotionEvent motionEvent) {
                if(motionEvent.getActionMasked() == MotionEvent.ACTION_HOVER_ENTER){
                    bt_godownload.setBackground(getResources().getDrawable(R.drawable.downloadhover));
                }
                return true;
            }
        });
        bt_godownload.setOnGenericMotionListener(new View.OnGenericMotionListener() {
            @Override
            public boolean onGenericMotion(View view, MotionEvent motionEvent) {
                if(motionEvent.getActionMasked() == MotionEvent.ACTION_HOVER_ENTER){
                    bt_godownload.setBackground(getResources().getDrawable(R.drawable.downloadhover));
                }
                return true;
            }
        });

        bt_update.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                checkVersion();
            }
        });

        bt_downloadmenu.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String[] neededPermission = Utils.getMissingPermission(IntroActivity.this);
                if (neededPermission.length > 0) {
                    pleaseSetPermission();
                    return;
                }
                if (Utils.isInternetAvailable(IntroActivity.this) == false) {
                    Utils.showMessage(IntroActivity.this, getResources().getString(R.string.missconnect));
                    return;
                }
                downloadFile();
            }
        });
    }

    void showDialogUpdate(final String url) {
        DialogInterface.OnClickListener dialogClickListener = new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                switch (which) {
                    case DialogInterface.BUTTON_POSITIVE:
                        mProgressDialog.show();
                        runDownloadVersion(url);
                        break;

                    case DialogInterface.BUTTON_NEGATIVE:
                        break;
                }
            }
        };

        AlertDialog.Builder builder = new AlertDialog.Builder(IntroActivity.this);
        builder.setCancelable(false);
        builder.setMessage("Your app have new Version. Do you want to download?").setPositiveButton("Yes", dialogClickListener)
                .setNegativeButton("No", dialogClickListener).show();
    }

    void checkVersion() {
        try {
            PackageInfo info = this.getPackageManager().getPackageInfo(this.getPackageName(), 0);
            final String versionclient = info.versionName;
            UserInfo user = BasicService.getInstance().LoadAcc(IntroActivity.this);
            if (user != null) {
                RestApiService.checkVersion(versionclient, user, new RestApiCallBack() {
                    @Override
                    public void onSuccess(Boolean success, String response, Object object) {
                        if (versionclient.equalsIgnoreCase(response)) {
                            showDialogUpdate(object.toString());
                        }
                    }

                    @Override
                    public void onFail(Boolean success, String error) {
                        Utils.showMessage(IntroActivity.this, error);
                    }
                });
            }
        } catch (Exception ex) {
            ex.printStackTrace();
        }

    }

    void downloaddata(UserInfo user) {
        RestApiService.DownloadSong(user, new RestApiCallBack() {
            @Override
            public void onSuccess(Boolean success, String response, Object object) {
                try {
                    JSONObject json = new JSONObject(response);
                    Utils.showMessage(IntroActivity.this, json.getString("mess"));
                    Intent intent = new Intent(IntroActivity.this, MainActivity.class);
                    IntroActivity.this.startActivity(intent);
                    mProgressDialogSong.dismiss();

                } catch (JSONException ex) {
                    mProgressDialogSong.dismiss();
                    ex.printStackTrace();
                    Utils.showMessage(IntroActivity.this, "Something error. Please try again!");
                }
            }

            @Override
            public void onFail(Boolean success, String error) {
                mProgressDialogSong.dismiss();
                Utils.showMessage(IntroActivity.this, error);
                if(error.equalsIgnoreCase("Token or username error")){
                    SharedPreferences sharedPref = getSharedPreferences("data", MODE_PRIVATE);
                    SharedPreferences.Editor prefEditor = sharedPref.edit();
                    prefEditor.putInt("isLogged", 0);
                    prefEditor.commit();
                    Intent intent = new Intent(IntroActivity.this, LoginActivity.class);
                    startActivity(intent);
                    finish();
                }
            }
        });
    }

    void configProgress() {
        mProgressDialog = new ProgressDialog(IntroActivity.this);
        mProgressDialog.setMessage("Downloading...");
        mProgressDialog.setIndeterminate(true);
        mProgressDialog.setProgressStyle(ProgressDialog.STYLE_HORIZONTAL);
        mProgressDialog.setCancelable(true);
        mProgressDialog.setCanceledOnTouchOutside(false);
    }

    void configProgressSong() {
        mProgressDialogSong = new ProgressDialog(IntroActivity.this);
        mProgressDialogSong.setMessage("Downloading...");
        mProgressDialogSong.setIndeterminate(true);
        mProgressDialogSong.setProgressStyle(ProgressDialog.STYLE_SPINNER);
        mProgressDialogSong.setCancelable(true);
        mProgressDialog.setCanceledOnTouchOutside(false);
    }

    void pleaseSetPermission() {
        DialogInterface.OnClickListener dialogClickListener = new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                switch (which) {
                    case DialogInterface.BUTTON_POSITIVE:
                        Utils.checkLELAPermission(IntroActivity.this);
                        break;

                    case DialogInterface.BUTTON_NEGATIVE:
                        break;
                }
            }
        };

        AlertDialog.Builder builder = new AlertDialog.Builder(IntroActivity.this);
        builder.setMessage("You have to allow permissions for KOONG Karaoke to continue. Set permissions now?").setPositiveButton("Yes", dialogClickListener)
                .setNegativeButton("No", dialogClickListener).show();
    }

    void downloadFile() {
        UserInfo user = BasicService.getInstance().LoadAcc(IntroActivity.this);
        if (user != null) {
            mProgressDialog.show();
            RestApiService.DownloadRestore(user, new RestApiCallBack() {
                @Override
                public void onSuccess(Boolean success, String response, Object object) {
                    ArrayList<String> url = new ArrayList<String>();
                    try {
                        JSONObject o = new JSONObject(response);
                        String menu = o.getString("menu");
                        String songlist = o.getString("songlist");

                        url.add(menu);
                        url.add(songlist);
                    } catch (JSONException ex) {
                        ex.printStackTrace();
                    }
                    runDownloadRestore(url);
                }

                @Override
                public void onFail(Boolean success, String error) {
                    mProgressDialog.dismiss();
                    Utils.showMessage(IntroActivity.this, error);
                    if(error.equalsIgnoreCase("Token or username error")){
                        SharedPreferences sharedPref = getSharedPreferences("data", MODE_PRIVATE);
                        SharedPreferences.Editor prefEditor = sharedPref.edit();
                        prefEditor.putInt("isLogged", 0);
                        prefEditor.commit();
                        Intent intent = new Intent(IntroActivity.this, LoginActivity.class);
                        startActivity(intent);
                        finish();
                    }
                }
            });
        }
    }

    void runDownloadRestore(final ArrayList<String> url) {
        DownloadRestore downloadrestore = new DownloadRestore(IntroActivity.this);
        downloadrestore.setCallback(new DownloadRestore.downloadTaskCallBack() {
            @Override
            public void updateCallBack(Integer value) {
                mProgressDialog.setIndeterminate(false);
                mProgressDialog.setMax(100);
                mProgressDialog.setProgress(value);
            }

            @Override
            public void successCallBack(String result) {
                mProgressDialog.dismiss();
                if (result != null) {
                    Utils.showMessage(IntroActivity.this, result);
                } else {
                    url.remove(0);
                    if (url.size() > 0) {
                        runDownloadRestore(url);
                    } else {
                        Utils.showMessage(IntroActivity.this, "Download Complete");
                    }
                }
            }
        });
        downloadrestore.execute(url.get(0));
    }

    void runDownloadVersion(String url) {
        DownloadVersion downloadversion = new DownloadVersion(IntroActivity.this);
        downloadversion.setCallback(new DownloadVersion.downloadTaskCallBack() {
            @Override
            public void updateCallBack(Integer value) {
                mProgressDialog.setIndeterminate(false);
                mProgressDialog.setMax(100);
                mProgressDialog.setProgress(value);
            }

            @Override
            public void successCallBack(String result, String filepath) {
                mProgressDialog.dismiss();
                if (result != null) {
                    Utils.showMessage(IntroActivity.this, result);
                } else {
                    Utils.showMessage(IntroActivity.this, "Download Success");
                    if (filepath != null) {
                        File file = new File(filepath);
                        MimeTypeMap map = MimeTypeMap.getSingleton();
                        String ext = MimeTypeMap.getFileExtensionFromUrl(file.getName());

                        String type = map.getMimeTypeFromExtension(ext);
                        if (type == null)
                            type = "*/*";
                        Intent intent = new Intent(Intent.ACTION_VIEW);
                        Uri data = Uri.fromFile(file);
                        intent.setDataAndType(data, type);

                        startActivity(intent);
                    }
                }
            }
        });
        downloadversion.execute(url);
    }

    @Override
    public void onBackPressed() {
        DialogInterface.OnClickListener dialogClickListener = new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                switch (which) {
                    case DialogInterface.BUTTON_POSITIVE:
                        IntroActivity.super.onBackPressed();
                        break;

                    case DialogInterface.BUTTON_NEGATIVE:
                        break;
                }
            }
        };

        AlertDialog.Builder builder = new AlertDialog.Builder(IntroActivity.this);
        builder.setMessage("Are you sure?").setPositiveButton("Yes", dialogClickListener)
                .setNegativeButton("No", dialogClickListener).show();

    }
}
