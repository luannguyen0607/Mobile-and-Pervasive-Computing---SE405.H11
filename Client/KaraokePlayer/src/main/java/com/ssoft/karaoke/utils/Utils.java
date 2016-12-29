package com.ssoft.karaoke.utils;

import android.Manifest;
import android.app.Activity;
import android.content.Context;
import android.content.pm.PackageManager;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Environment;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.widget.Toast;

import com.ssoft.karaoke.activity.MainActivity;

import java.io.File;
import java.util.ArrayList;

/**
 * Created by luan.nt on 12/5/2016.
 */
public class Utils {

    public static void showMessage(Context context, String m) {
        Toast.makeText(context, m, Toast.LENGTH_SHORT).show();
    }

    public static boolean isInternetAvailable(Context context) {
        ConnectivityManager connectivityManager = (ConnectivityManager) context.getApplicationContext().getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo i = connectivityManager.getActiveNetworkInfo();
        if (i == null)
            return false;
        if (!i.isConnected())
            return false;
        if (!i.isAvailable())
            return false;
        return true;
    }

    public static String[] getMissingPermission(Context context) {
        ArrayList<String> ps = new ArrayList<>();

        if (ContextCompat.checkSelfPermission(context, Manifest.permission.INTERNET) != PackageManager.PERMISSION_GRANTED) {
            ps.add(Manifest.permission.INTERNET);
        }
        if (ContextCompat.checkSelfPermission(context, Manifest.permission.READ_EXTERNAL_STORAGE) != PackageManager.PERMISSION_GRANTED) {
            ps.add(Manifest.permission.READ_EXTERNAL_STORAGE);
        }
        if (ContextCompat.checkSelfPermission(context, Manifest.permission.WRITE_EXTERNAL_STORAGE) != PackageManager.PERMISSION_GRANTED) {
            ps.add(Manifest.permission.WRITE_EXTERNAL_STORAGE);
        }
        if (ContextCompat.checkSelfPermission(context, Manifest.permission.WAKE_LOCK) != PackageManager.PERMISSION_GRANTED) {
            ps.add(Manifest.permission.WAKE_LOCK);
        }
        return ps.toArray(new String[0]);
    }

    public static void checkLELAPermission(Activity context) {
        String[] neededPermissions = Utils.getMissingPermission(context);
        if (neededPermissions.length > 0) {
            ActivityCompat.requestPermissions(context,
                    neededPermissions,
                    MainActivity.KOONG_KARAOKE_PERMISSIONS);
        }
    }

    public static String generateFilename() {
        String check = "001";
        boolean finded = false;

        while (!finded) {
            String[] extention = {".mp4", ".avi", ".mpg", ".dat", ".vob", ".wma", ".mp3", ".mkv"};
            for (int i = 0; i < extention.length; i++) {
                File file = new File(Environment.getExternalStorageDirectory() + "/90/" + check + extention[i]);
                if (file.exists()) {
                    int filename = Integer.parseInt(check);
                    check = String.valueOf(filename + 1);
                    if (filename < 9) {
                        check = "00" + check;
                    } else if (filename < 99) {
                        check = "0" + check;
                    }
                    break;
                } else {
                    if (i == (extention.length - 1)) {
                        finded = true;
                    }
                }
            }
        }
        return check;
    }

    public static String getFileName() {
        String check = "001";
        boolean finded = false;

        while (!finded) {
            String[] extention = {".mp4", ".avi", ".mpg", ".dat", ".vob", ".wma", ".mp3", ".mkv"};
            for (int i = 0; i < extention.length; i++) {
                File file = new File(Environment.getExternalStorageDirectory() + "/90/" + check + extention[i]);
                if (file.exists()) {
                    int filename = Integer.parseInt(check);
                    check = String.valueOf(filename + 1);
                    if (filename < 9) {
                        check = "00" + check;
                    } else if (filename < 99) {
                        check = "0" + check;
                    }
                    break;
                } else {
                    if (i == (extention.length - 1)) {
                        finded = true;
                        int filename = Integer.parseInt(check);
                        check = String.valueOf(filename - 1);
                        if (filename <= 10) {
                            check = "00" + check;
                        } else if (filename <= 100) {
                            check = "0" + check;
                        }
                    }
                }
            }
        }
        return check;
    }
}
