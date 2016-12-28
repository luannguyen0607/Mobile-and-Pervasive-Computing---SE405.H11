package com.ssoft.karaoke.service;

import android.content.Context;
import android.os.PowerManager;
import android.util.Log;
import android.widget.Toast;

import com.ssoft.karaoke.activity.MainActivity;
import com.ssoft.karaoke.model.UserInfo;
import com.ssoft.karaoke.utils.Utils;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.DataOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;
import java.util.ArrayList;
import java.util.List;
//import org.apache.commons.io.IOUtils;

/**
 * Created by luan.nt on 12/8/2016.
 */
public class UploadService {
    final static String upLoadServerUri = "http://210.245.102.163/luan/rest_api.php";

    public interface UploadCallBack {
        void successCallBack(String result);

        void failCallBack(String error);
    }

    private PowerManager.WakeLock mWakeLock;

    public static void uploadFile(String sourceFileUri, final UserInfo user, final UploadCallBack callBack) {

        String fileName = sourceFileUri;

        HttpURLConnection conn = null;
        DataOutputStream dos = null;
        String lineEnd = "\r\n";
        String twoHyphens = "--";
        String boundary = "*****";
        String response = "";
        int bytesRead, bytesAvailable, bufferSize, serverResponseCode = 0;
        byte[] buffer;
        int maxBufferSize = 1 * 1024 * 1024;
        File sourceFile = new File(fileName);

        if (!sourceFile.isFile()) {
            response = "file not exists";
            callBack.failCallBack(response);
        } else {
            try {
                // open a URL connection to the Servlet
                FileInputStream fileInputStream = new FileInputStream(sourceFile);
                URL url = new URL(upLoadServerUri);

                // Open a HTTP  connection to  the URL
                conn = (HttpURLConnection) url.openConnection();
                conn.setDoInput(true); // Allow Inputs
                conn.setDoOutput(true); // Allow Outputs
                conn.setUseCaches(false); // Don't use a Cached Copy
                conn.setRequestMethod("POST");
                conn.setConnectTimeout(5000);
                conn.setRequestProperty("Connection", "Keep-Alive");
                conn.setRequestProperty("ENCTYPE", "multipart/form-data");
                conn.setRequestProperty("Content-Type", "multipart/form-data;boundary=" + boundary);
                conn.setRequestProperty("uploaded_file", fileName);
                conn.setRequestProperty("action", "upload");
                conn.setRequestProperty("username", user.getUsername());
                conn.setRequestProperty("token", user.getToken());

                OutputStream os = conn.getOutputStream();
                BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(os, "UTF-8"));
                dos = new DataOutputStream(conn.getOutputStream());

                //first parameter - email
                dos.writeBytes(twoHyphens + boundary + lineEnd);
                dos.writeBytes("Content-Disposition: form-data; name=\"action\"" + lineEnd + lineEnd
                        + "upload" + lineEnd);

                //second parameter - userName
                dos.writeBytes(twoHyphens + boundary + lineEnd);
                dos.writeBytes("Content-Disposition: form-data; name=\"username\"" + lineEnd + lineEnd
                        + user.getUsername() + lineEnd);

                //third parameter - password
                dos.writeBytes(twoHyphens + boundary + lineEnd);
                dos.writeBytes("Content-Disposition: form-data; name=\"token\"" + lineEnd + lineEnd
                        + user.getToken() + lineEnd);

                dos.writeBytes(twoHyphens + boundary + lineEnd);
                dos.writeBytes("Content-Disposition: form-data; name=\"uploaded_file\";filename=\""
                        + fileName + "\"" + lineEnd);

                //dos.ap
                dos.writeBytes(lineEnd);

                // create a buffer of  maximum size
                bytesAvailable = fileInputStream.available();

                bufferSize = Math.min(bytesAvailable, maxBufferSize);
                buffer = new byte[bufferSize];

                // read file and write it into form...
                bytesRead = fileInputStream.read(buffer, 0, bufferSize);

                while (bytesRead > 0) {

                    dos.write(buffer, 0, bufferSize);
                    bytesAvailable = fileInputStream.available();
                    bufferSize = Math.min(bytesAvailable, maxBufferSize);
                    bytesRead = fileInputStream.read(buffer, 0, bufferSize);

                }

                // send multipart form data necesssary after file data...
                dos.writeBytes(lineEnd);
                dos.writeBytes(twoHyphens + boundary + twoHyphens + lineEnd);

                BufferedReader br;
                // Responses from the server (code and message)
                serverResponseCode = conn.getResponseCode();
                if (200 <= conn.getResponseCode() && conn.getResponseCode() <= 299) {
                    br = new BufferedReader(new InputStreamReader((conn.getInputStream())));
                } else {
                    br = new BufferedReader(new InputStreamReader((conn.getErrorStream())));
                }
                response = br.readLine();
                try {
                    JSONObject o = new JSONObject(response);
                    String mess = o.getString("mess");
                    callBack.successCallBack(mess);
                } catch (JSONException ex) {
                    callBack.failCallBack(ex.getMessage());
                }


                String serverResponseMessage = conn.getResponseMessage();


                Log.i("uploadFile", "HTTP Response is : "
                        + serverResponseMessage + ": " + serverResponseCode);

                //close the streams //
                fileInputStream.close();
                dos.flush();
                dos.close();

            } catch (MalformedURLException ex) {
                ex.printStackTrace();
                Log.e("Upload file to server", "error: " + ex.getMessage(), ex);
            } catch (Exception e) {
                e.printStackTrace();
            }
        } // End else block
    }
}
