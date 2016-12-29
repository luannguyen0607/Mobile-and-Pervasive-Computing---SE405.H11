package com.ssoft.karaoke.service;

import android.content.Context;
import android.os.AsyncTask;
import android.os.Environment;
import android.os.PowerManager;
import android.webkit.URLUtil;

import com.ssoft.karaoke.activity.MainActivity;
import com.ssoft.karaoke.utils.Utils;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;

/**
 * Created by luan.nt on 12/6/2016.
 */
public class DownloadTask extends AsyncTask<String, Integer, String> {

    public interface downloadTaskCallBack {
        void updateCallBack(Integer value);

        void successCallBack(String result);
    }

    private downloadTaskCallBack callBack;
    private Context context;
    private PowerManager.WakeLock mWakeLock;
    private File file;

    public DownloadTask(Context context) {
        this.context = context;
    }

    public void setCallback(downloadTaskCallBack downloadTaskCallBack) {
        this.callBack = downloadTaskCallBack;
    }

    @Override
    protected String doInBackground(String... sUrl) {
        InputStream input = null;
        FileOutputStream output = null;
        HttpURLConnection connection = null;
        try {
            URL url = new URL(sUrl[0]);
            String file = URLUtil.guessFileName(sUrl[0], null, null);
            String filetype = file.substring(file.lastIndexOf("."), file.length());
            connection = (HttpURLConnection) url.openConnection();
            connection.connect();

            // expect HTTP 200 OK, so we don't mistakenly save error report
            // instead of the file
            if (connection.getResponseCode() != HttpURLConnection.HTTP_OK) {
                return "Server returned HTTP " + connection.getResponseCode()
                        + " " + connection.getResponseMessage();
            }

            // this will be useful to display download percentage
            // might be -1: server did not report the length
            int fileLength = connection.getContentLength();

            // download the file
            input = connection.getInputStream();
            String filename = Utils.generateFilename();
            File folder = new File(Environment.getExternalStorageDirectory() + "/90");

            boolean success = true;
            if (!folder.exists()) {
                success = folder.mkdir();
            }
            if (success) {
                output = new FileOutputStream(folder + "/" + filename + filetype);
            } else {
                // Do something else on failure
            }

            this.file = new File(Environment.getExternalStorageDirectory() + "/90/" + filename + filetype);
            BasicService.getInstance().CurrentSong = new File(Environment.getExternalStorageDirectory() + "/90/" + filename + filetype);

            byte data[] = new byte[4096];
            long total = 0;
            int count;
            while ((count = input.read(data)) != -1) {
                // allow canceling with back button
                if (isCancelled()) {
                    input.close();
                    return null;
                }
                total += count;
                // publishing the progress....
                if (fileLength > 0) // only if total length is known
                    publishProgress((int) (total * 100 / fileLength));
                output.write(data, 0, count);
                if (!Utils.isInternetAvailable(context)) {
                    this.file.delete();
                }
            }
        } catch (Exception e) {
            if(!Utils.isInternetAvailable(context)){
                this.file.delete();
            }
            return e.toString();
        } finally {
            try {
                if (output != null)
                    output.close();
                if (input != null)
                    input.close();
            } catch (IOException ignored) {
                if(!Utils.isInternetAvailable(context)){
                    this.file.delete();
                }
            }

            if (connection != null) {
                if(!Utils.isInternetAvailable(context)){
                    this.file.delete();
                }
                connection.disconnect();
            }

        }
        return null;
    }

    @Override
    protected void onPreExecute() {
        super.onPreExecute();
        // take CPU lock to prevent CPU from going off if the user
        // presses the power button during download
        PowerManager pm = (PowerManager) context.getSystemService(Context.POWER_SERVICE);
        mWakeLock = pm.newWakeLock(PowerManager.PARTIAL_WAKE_LOCK,
                getClass().getName());
        mWakeLock.acquire();
    }

    @Override
    protected void onProgressUpdate(Integer... progress) {
        if (!Utils.isInternetAvailable(context)) {
            this.file.delete();
        }
        super.onProgressUpdate(progress);
        this.callBack.updateCallBack(progress[0]);
    }

    @Override
    protected void onCancelled(String s) {
        super.onCancelled(s);
        this.file.delete();
    }

    @Override
    protected void onPostExecute(String result) {
        mWakeLock.release();
        this.callBack.successCallBack(result);
    }
}
