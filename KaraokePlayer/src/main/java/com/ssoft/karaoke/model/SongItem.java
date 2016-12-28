package com.ssoft.karaoke.model;

/**
 * Created by luan.nt on 12/5/2016.
 */
public class SongItem extends Song {

    private String filetype = "";

    public boolean isSelected() {
        return selected;
    }

    public void setSelected(boolean selected) {
        this.selected = selected;
    }

    private boolean selected = false;

    public SongItem() {

    }

    public SongItem(Song song, String filetype) {
        super(song);
        this.filetype = filetype;
    }

    public String getfiletype() {
        return filetype;
    }

    public void setfiletype(String filetype) {
        this.filetype = filetype;
    }

}
