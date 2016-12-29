package com.ssoft.karaoke.adapter;

import android.app.Activity;
import android.content.Context;
import android.graphics.Color;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.ssoft.karaoke.R;
import com.ssoft.karaoke.model.Song;
import com.ssoft.karaoke.model.SongItem;

import java.util.ArrayList;

/**
 * Created by luan.nt on 12/5/2016.
 */
public class SongOwnedAdapter extends BaseAdapter {

    private Context _context;
    private ArrayList<SongItem> _items;
    private Activity _activity;

    public SongOwnedAdapter(Activity activiy, Context context, ArrayList<SongItem> Items) {
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
        try {
            LayoutInflater mInflater = _activity.getLayoutInflater();
            if (view == null) {
                view = mInflater.inflate(R.layout.song_item, null);
            }
//            if (this._items.get(i).isSelected()) {
//                view.setBackgroundColor(Color.BLUE);
//            }

            TextView ID = (TextView) view.findViewById(R.id.song_ID);
            TextView name = (TextView) view.findViewById(R.id.song_name);
            TextView singer = (TextView) view.findViewById(R.id.song_singer);

            ID.setText(String.valueOf(this._items.get(i).getSongID()));
            name.setText(this._items.get(i).getSongName());
            singer.setText(String.valueOf(this._items.get(i).getSinger()));
        } catch (Exception ex) {
            Log.e("", "");
        }
        return view;
    }
}

