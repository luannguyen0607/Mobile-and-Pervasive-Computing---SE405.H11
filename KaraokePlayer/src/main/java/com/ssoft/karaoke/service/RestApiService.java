package com.ssoft.karaoke.service;

import com.google.gson.Gson;
import com.loopj.android.http.AsyncHttpClient;
import com.loopj.android.http.AsyncHttpResponseHandler;
import com.loopj.android.http.RequestParams;
import com.ssoft.karaoke.model.GetSongResponse;
import com.ssoft.karaoke.model.Song;
import com.ssoft.karaoke.model.UserInfo;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.ArrayList;

/**
 * Created by luan.nt on 12/7/2016.
 */
public final class RestApiService {
    static AsyncHttpClient client = new AsyncHttpClient();

    static String serverURL = "http://210.245.102.163/luan/rest_api.php";

    public static void Login(UserInfo user, final RestApiCallBack callback) {
        RequestParams params = new RequestParams();
        params.put("action", "login");
        params.put("username", user.getUsername());
        params.put("password", user.getPassword());
        client.setTimeout(5000);

        client.post(serverURL, params, new AsyncHttpResponseHandler() {
            @Override
            public void onSuccess(String response) {
                try {
                    JSONObject json = new JSONObject(response);
                    String status = json.getString("status");
                    String mess = json.getString("mess");
                    if (status != null && status.toString().equals("true")) {
                        callback.onSuccess(true, response, mess);
                    } else {
                        status = json.getString("mess");
                        if (status != null) {
                            callback.onFail(false, status);
                        }
                    }
                } catch (Exception ex) {
                    callback.onFail(false, "JSONexception");
                }
            }

            @Override
            public void onFailure(int statusCode, Throwable error, String content) {
                callback.onFail(false, content);
            }
        });
    }

    public static void DownloadSong(UserInfo user, final RestApiCallBack callback) {
        BasicService.SongRequest = new ArrayList<Song>();
        RequestParams params = new RequestParams();
        params.put("action", "get_song");
        params.put("username", user.getUsername());
        params.put("token", user.getToken());
        client.setTimeout(5000);

        client.post(serverURL, params, new AsyncHttpResponseHandler() {
            @Override
            public void onSuccess(String response) {
                try {
                    Gson gson = new Gson();
                    GetSongResponse getSongResponse = gson.fromJson(response, GetSongResponse.class);
                    if (getSongResponse.getStatus().trim().equalsIgnoreCase("true")) {
                        BasicService.getInstance().SongRequest.addAll(getSongResponse.getData());
                        callback.onSuccess(true, response, getSongResponse.getMess());
                    } else {
                        callback.onFail(true, getSongResponse.getMess());
                    }

                } catch (Exception ex) {
                    callback.onFail(false, "JSONexception");
                }
            }

            @Override
            public void onFailure(int statusCode, Throwable error, String content) {
                callback.onFail(false, content);
            }
        });
    }

    public static void DownloadComplete(int id, UserInfo user, final RestApiCallBack callback) {
        RequestParams params = new RequestParams();
        params.put("action", "download");
        params.put("id", id + "");
        params.put("username", user.getUsername());
        params.put("token", user.getToken());
        client.setTimeout(5000);

        client.post(serverURL, params, new AsyncHttpResponseHandler() {
            @Override
            public void onSuccess(String response) {
                try {
                    JSONObject json = new JSONObject(response);
                    String status = json.getString("status");
                    String mess = json.getString("mess");
                    if (status != null && status.toString().equals("true")) {
                        callback.onSuccess(true, response, mess);
                    } else {
                        status = json.getString("mess");
                        if (status != null) {
                            callback.onFail(false, status);
                        }
                    }
                } catch (Exception ex) {
                    callback.onFail(false, "JSONexception");
                }
            }

            @Override
            public void onFailure(int statusCode, Throwable error, String content) {
                callback.onFail(false, content);
            }
        });
    }

    public static void DownloadRestore(UserInfo user, final RestApiCallBack callback) {
        RequestParams params = new RequestParams();
        params.put("action", "restore");
        params.put("username", user.getUsername());
        params.put("token", user.getToken());
        client.setTimeout(5000);

        client.post(serverURL, params, new AsyncHttpResponseHandler() {
            @Override
            public void onSuccess(String response) {
                try {
                    JSONObject json = new JSONObject(response);
                    String status = json.getString("status");
                    String mess = json.getString("mess");
                    if (status != null && status.toString().equals("true")) {
                        String data = json.getString("data");
                        callback.onSuccess(true, data, mess);
                    } else {
                        status = json.getString("mess");
                        if (status != null) {
                            callback.onFail(false, status);
                        }
                    }
                } catch (Exception ex) {
                    callback.onFail(false, "JSONexception");
                }
            }

            @Override
            public void onFailure(int statusCode, Throwable error, String content) {
                callback.onFail(false, content);
            }
        });
    }

    public static void checkVersion(String version, UserInfo user, final RestApiCallBack callback) {
        RequestParams params = new RequestParams();
        params.put("action", "checkforupdate");
        params.put("version", version);
        client.setTimeout(5000);

        client.post(serverURL, params, new AsyncHttpResponseHandler() {
            @Override
            public void onSuccess(String response) {
                try {
                    JSONObject json = new JSONObject(response);
                    String status = json.getString("status");
                    String mess = json.getString("mess");
                    if (status != null && status.toString().equals("true")) {
                        String data = json.getString("data");
                        callback.onSuccess(true, mess, data);
                    } else {
                        if (status != null) {
                            callback.onFail(false, mess);
                        }
                    }
                } catch (Exception ex) {
                    callback.onFail(false, "JSONexception");
                }
            }

            @Override
            public void onFailure(int statusCode, Throwable error, String content) {
                callback.onFail(false, content);
            }
        });
    }
}
