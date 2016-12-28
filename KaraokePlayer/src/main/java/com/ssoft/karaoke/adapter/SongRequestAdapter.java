package com.ssoft.karaoke.adapter;

import android.app.Activity;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.CheckBox;
import android.widget.TextView;

import com.ssoft.karaoke.R;
import com.ssoft.karaoke.model.Song;
import com.ssoft.karaoke.model.SongItem;

import java.util.ArrayList;

/**
 * Created by luan.nt on 12/5/2016.
 */
public class SongRequestAdapter extends BaseAdapter {

    private Context _context;
    //private ArrayList<SongItem> _items;
    private ArrayList<Song> _items;
    private Activity _activity;

    public SongRequestAdapter(Activity activiy, Context context, ArrayList<Song> Items){
        super();
        this._context = context;
        this._items = Items;
        this._activity = activiy;
    }
    @Override
    public int getCount() {
        return this._items.size();
    }

    @Override
    public Object getItem(int i) {
        return this._items.get(i);
    }

    @Override
    public long getItemId(int i) {
        return i;
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        try{
            LayoutInflater mInflater =  _activity.getLayoutInflater();
            if (view == null) {
                view = mInflater.inflate(R.layout.song_request_item, null);
            }

            TextView name = (TextView) view.findViewById(R.id.song_name);
            TextView singer = (TextView) view.findViewById(R.id.song_singer);
            //CheckBox check = (CheckBox)view.findViewById(R.id.song_request_checkbox);

//            if (_items.get(i).getChecked()) {
//                check.setChecked(true);
//            }else{
//                check.setChecked(false);
//            }
            name.setText(this._items.get(i).getSongName());
            singer.setText(String.valueOf(this._items.get(i).getSinger()));
        }
        catch(Exception ex){
            ex.printStackTrace();
        }
        return view;
    }
}
