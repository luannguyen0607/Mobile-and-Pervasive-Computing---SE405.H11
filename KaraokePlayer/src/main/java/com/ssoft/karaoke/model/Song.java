package com.ssoft.karaoke.model;

import com.google.gson.annotations.SerializedName;

/**
 * Created by luan.nt on 12/5/2016.
 */
public class Song {
    @SerializedName("id")
    private int usersong_id;
    @SerializedName("song_name")
    private String songName;
    @SerializedName("song_position")
    private String Position;
    @SerializedName("singer_name")
    private String singer;
    @SerializedName("name_count")
    private String countword;
    @SerializedName("lang_code")
    private String Songlang;
    @SerializedName("song_volume")
    private String Volumn;
    @SerializedName("name_spell")
    private String Spelling_song;
    @SerializedName("song_id")
    private String songID;
    @SerializedName("singer_spell")
    private String Spelling_singer;
    @SerializedName("singer_class")
    private String Singer_class;
    @SerializedName("song_type")
    private String Song_type_code;
    @SerializedName("album_name")
    private String Album_name;
    @SerializedName("album_spell")
    private String Spelling_album;
    @SerializedName("singer_photo")
    private String Singer_photo;
    @SerializedName("song_lyric")
    private String Song_lyric;
    @SerializedName("url")
    private String Url;

    public String getPosition() {
        return Position;
    }

    public void setPosition(String position) {
        Position = position;
    }

    public String getAlbum_name() {
        return Album_name;
    }

    public void setAlbum_name(String album_name) {
        Album_name = album_name;
    }

    public String getCountword() {
        return countword;
    }

    public void setCountword(String countword) {
        this.countword = countword;
    }

    public String getSinger() {
        return singer;
    }

    public void setSinger(String singer) {
        this.singer = singer;
    }

    public String getSinger_class() {
        return Singer_class;
    }

    public void setSinger_class(String singer_class) {
        Singer_class = singer_class;
    }

    public String getSinger_photo() {
        return Singer_photo;
    }

    public void setSinger_photo(String singer_photo) {
        Singer_photo = singer_photo;
    }

    public String getSong_lyric() {
        return Song_lyric;
    }

    public void setSong_lyric(String song_lyric) {
        Song_lyric = song_lyric;
    }

    public String getSong_type_code() {
        return Song_type_code;
    }

    public void setSong_type_code(String song_type_code) {
        Song_type_code = song_type_code;
    }

    public String getSongID() {
        return songID;
    }

    public void setSongID(String songID) {
        this.songID = songID;
    }

    public String getSonglang() {
        return Songlang;
    }

    public void setSonglang(String songlang) {
        Songlang = songlang;
    }

    public String getSongName() {
        return songName;
    }

    public void setSongName(String songName) {
        this.songName = songName;
    }

    public String getSpelling_album() {
        return Spelling_album;
    }

    public void setSpelling_album(String spelling_album) {
        Spelling_album = spelling_album;
    }

    public String getSpelling_singer() {
        return Spelling_singer;
    }

    public void setSpelling_singer(String spelling_singer) {
        Spelling_singer = spelling_singer;
    }

    public String getSpelling_song() {
        return Spelling_song;
    }

    public void setSpelling_song(String spelling_song) {
        Spelling_song = spelling_song;
    }

    public String getUrl() {
        return Url;
    }

    public void setUrl(String url) {
        Url = url;
    }

    public int getUsersong_id() {
        return usersong_id;
    }

    public void setUsersong_id(int usersong_id) {
        this.usersong_id = usersong_id;
    }

    public String getVolumn() {
        return Volumn;
    }

    public void setVolumn(String volumn) {
        Volumn = volumn;
    }

    public Song() {

    }
    public Song(String id, String name, String singer){
        this.songID = id;
        this.songName = name;
        this.singer = singer;

    }
    public Song(Song song){
        this.songID = song.getSongID();
        this.songName = song.getSongName();
        this.singer = song.getSinger();
        this.Url = song.getUrl();
    }
}
