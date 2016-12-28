package com.ssoft.karaoke.service;

/**
 * Created by luan.nt on 12/7/2016.
 */
public interface RestApiCallBack {
    public void onSuccess(Boolean success, String response, Object object);
    public void onFail(Boolean success, String error);
}
