package com.ssoft.karaoke.model;

import com.google.gson.annotations.SerializedName;

import java.util.List;

public class GetSongResponse {
    @SerializedName("status")
    public String status;
    @SerializedName("data")
    public List<Song> data;
    @SerializedName("mess")
    public String mess;

    public List<Song> getData() {
        return data;
    }

    public String getMess() {
        return mess;
    }

    public String getStatus() {
        return status;
    }
}
