package com.ssoft.karaoke.service;

import android.content.Context;
import android.content.SharedPreferences;

import com.ssoft.karaoke.model.Song;
import com.ssoft.karaoke.model.SongItem;
import com.ssoft.karaoke.model.UserInfo;

import java.io.File;
import java.util.ArrayList;

/**
 * Created by luan.nt on 12/8/2016.
 */
public class BasicService {
    public UserInfo currentUser;
    private static BasicService instance;
    private final String AUTO_LOGIN_KEY = "autologin_koongkara";
    public static ArrayList<Song> SongRequest = new ArrayList<Song>();
    public static ArrayList<SongItem> SongOwner = new ArrayList<SongItem>();
    public static File CurrentSong;

    private BasicService() {

    }

    public static BasicService getInstance() {
        if (instance == null) {
            instance = new BasicService();
        }
        return instance;
    }

    public void SaveAcc(String username, String pass, String token, Context context) {
        SharedPreferences preferences = context.getSharedPreferences(AUTO_LOGIN_KEY, Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = preferences.edit();
        editor.putString("accUser", username);
        editor.putString("accPass", pass);
        editor.putString("acctoken", token);
        editor.commit();
    }

    public UserInfo LoadAcc(Context context) {
        SharedPreferences prefs = context.getSharedPreferences(AUTO_LOGIN_KEY, Context.MODE_PRIVATE);
        String email = prefs.getString("accUser", "");
        String pass = prefs.getString("accPass", "");
        String token = prefs.getString("acctoken", "");

        if (email.equals("")) {
            return null;
        }

        UserInfo u = new UserInfo();
        u.setUsername(email);
        u.setPassword(pass);
        u.setToken(token);

        return u;
    }
}
