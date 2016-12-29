package com.ssoft.karaoke.activity;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.net.Uri;
import android.os.Environment;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.ImageButton;
import android.widget.ListView;

import com.ssoft.karaoke.R;
import com.ssoft.karaoke.adapter.SongOwnedAdapter;
import com.ssoft.karaoke.adapter.SongRequestAdapter;
import com.ssoft.karaoke.model.Song;
import com.ssoft.karaoke.model.SongItem;
import com.ssoft.karaoke.model.UserInfo;
import com.ssoft.karaoke.service.BasicService;
import com.ssoft.karaoke.service.DownloadTask;
import com.ssoft.karaoke.service.RestApiCallBack;
import com.ssoft.karaoke.service.RestApiService;
import com.ssoft.karaoke.service.UploadService;
import com.ssoft.karaoke.utils.Utils;

import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.FileReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.util.ArrayList;
import java.util.List;

public class MainActivity extends Activity {

    public static final int KOONG_KARAOKE_PERMISSIONS = 0000;
    private ListView listsongrequest, listsongowned;
    private ArrayList<SongItem> listowner;
    private ArrayList<Song> listrequest;
    private SongOwnedAdapter SongOwnedAdapter;
    private SongRequestAdapter SongRequestAdapter;
    private ProgressDialog mProgressDialog;
    private Button btn_download, btn_requestup, btn_requestdown, btn_downloadedup, btn_downloadeddown;
    private DownloadTask downloadTask;
    private String mess;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        listsongrequest = (ListView) findViewById(R.id.songrequestList);
        listsongowned = (ListView) findViewById(R.id.songList);
        btn_download = (Button) findViewById(R.id.btn_download);

        btn_requestup = (Button) findViewById(R.id.btn_requestup);
        btn_requestdown = (Button) findViewById(R.id.btn_requestdown);
        btn_downloadedup = (Button) findViewById(R.id.btn_downloadedup);
        btn_downloadeddown = (Button) findViewById(R.id.btn_downloadeddown);

        configProgress();
        configControlEvent();
        loaddata();
    }

    void pleaseSetPermission() {
        DialogInterface.OnClickListener dialogClickListener = new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                switch (which) {
                    case DialogInterface.BUTTON_POSITIVE:
                        Utils.checkLELAPermission(MainActivity.this);
                        break;

                    case DialogInterface.BUTTON_NEGATIVE:
                        break;
                }
            }
        };

        AlertDialog.Builder builder = new AlertDialog.Builder(MainActivity.this);
        builder.setMessage("You have to allow permissions for KOONG Karaoke to continue. Set permissions now?").setPositiveButton("Yes", dialogClickListener)
                .setNegativeButton("No", dialogClickListener).show();
    }

    void configControlEvent() {
        btn_download.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String[] neededPermission = Utils.getMissingPermission(MainActivity.this);
                if (neededPermission.length > 0) {
                    pleaseSetPermission();
                    return;
                }
                if (Utils.isInternetAvailable(MainActivity.this) == false) {
                    Utils.showMessage(MainActivity.this, getResources().getString(R.string.missconnect));
                    return;
                }
                listrequest = BasicService.getInstance().SongRequest;

                if (listrequest.size() == 0 || listrequest.isEmpty()) {
                    Utils.showMessage(MainActivity.this, getResources().getString(R.string.nothingSong));
                    return;
                }
                downloadFile();
            }
        });

        mProgressDialog.setOnCancelListener(new DialogInterface.OnCancelListener() {
            @Override
            public void onCancel(DialogInterface dialog) {
                if (BasicService.getInstance().CurrentSong != null) {
                    BasicService.getInstance().CurrentSong.delete();
                }
                downloadTask.cancel(true);
                loaddata();
            }
        });

        btn_requestup.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (listsongrequest.getFirstVisiblePosition() > 0) {
                    listsongrequest.smoothScrollToPosition(listsongrequest.getFirstVisiblePosition() - 5);
                } else {
                    listsongrequest.smoothScrollToPosition(0);
                }
            }
        });

        btn_requestdown.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (listsongrequest.getLastVisiblePosition() < listsongrequest.getAdapter().getCount()) {
                    listsongrequest.smoothScrollToPosition(listsongrequest.getLastVisiblePosition() + 5);
                } else {
                    listsongrequest.smoothScrollToPosition(listsongrequest.getAdapter().getCount());
                }
            }
        });

        btn_downloadedup.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (listsongowned.getFirstVisiblePosition() > 0) {
                    listsongowned.smoothScrollToPosition(listsongowned.getFirstVisiblePosition() - 5);
                } else {
                    listsongowned.smoothScrollToPosition(0);
                }
            }
        });

        btn_downloadeddown.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (listsongowned.getLastVisiblePosition() < listsongowned.getAdapter().getCount()) {
                    listsongowned.smoothScrollToPosition(listsongowned.getLastVisiblePosition() + 5);
                } else {
                    listsongowned.smoothScrollToPosition(listsongowned.getAdapter().getCount());
                }
            }
        });
        listsongowned.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> adapterView, View view, int i, long l) {
                //listowner.get(i).setSelected(listowner.get(i).isSelected());

                String filename = listowner.get(i).getSongID().substring(2) + "." + listowner.get(i).getfiletype();
                String pathname = Environment.getExternalStorageDirectory() + "/" + listowner.get(i).getSongID().substring(0, 2) + "/";
                //File mydir = MainActivity.this.getDir("Videos", MODE_WORLD_READABLE);
                File fileWithinMyDir = new File(pathname + filename);
                fileWithinMyDir.setReadable(true, false);
                String videoResource = fileWithinMyDir.getPath();
                Uri intentUri = Uri.fromFile(new File(videoResource));

                Intent intent = new Intent();
                intent.setAction(Intent.ACTION_VIEW);
                intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                intent.setDataAndType(intentUri, "video/*");
                startActivity(intent);
            }
        });
    }

    void downloadFile() {
        listrequest = BasicService.getInstance().SongRequest;
        mProgressDialog.show();
        runDownloadTask(listrequest, new onDownloadSongCallback() {
            @Override
            public void onSuccess() {
                if (mProgressDialog.isShowing()) {
                    mProgressDialog.dismiss();
                    new Thread(new Runnable() {
                        public void run() {
                            runOnUiThread(new Runnable() {
                                public void run() {
                                    Utils.showMessage(MainActivity.this, "Uploading...");
                                    loaddata();
                                }
                            });
                            uploadFile();
                        }
                    }).start();
                }
            }
        });
    }

    void runDownloadTask(final List<Song> songs, final onDownloadSongCallback callback) {
        mProgressDialog.setMessage("Downloading...(" + songs.size() + " left)");
        if (!Utils.isInternetAvailable(MainActivity.this)) {
            mProgressDialog.dismiss();
            downloadFile();
            return;
        }
        if (songs.size() > 0) {
            Song song = songs.get(0);
            downloadSong(song, new onDownloadSongCallback() {
                @Override
                public void onSuccess() {
                    songs.remove(0);
                    SongRequestAdapter.notifyDataSetChanged();
                    runDownloadTask(songs, callback);
                }
            });
        } else {
            callback.onSuccess();
        }
    }

    private interface onDownloadSongCallback {
        void onSuccess();
    }

    void downloadSong(final Song song, final onDownloadSongCallback callback) {
        final UserInfo user = BasicService.getInstance().LoadAcc(MainActivity.this);
        downloadTask = new DownloadTask(MainActivity.this);
        downloadTask.setCallback(new DownloadTask.downloadTaskCallBack() {
            @Override
            public void updateCallBack(Integer value) {
                mProgressDialog.setIndeterminate(false);
                mProgressDialog.setMax(100);
                mProgressDialog.setProgress(value);
            }

            @Override
            public void successCallBack(String result) {
                mProgressDialog.setProgress(0);
                if (result != null) {
                    Utils.showMessage(MainActivity.this, result);
                } else {
                    DownloadCompleted(song.getUsersong_id(), user, song, new onDownloadCompletedCallback() {
                        @Override
                        public void onSuccess() {
                            callback.onSuccess();
                        }
                    });
                }
            }
        });
        downloadTask.execute(song.getUrl());
    }

    void configProgress() {
        mProgressDialog = new ProgressDialog(MainActivity.this);
        mProgressDialog.setMessage("Downloading...");
        mProgressDialog.setIndeterminate(true);
        mProgressDialog.setProgressStyle(ProgressDialog.STYLE_HORIZONTAL);
        mProgressDialog.setCancelable(true);
        mProgressDialog.setCanceledOnTouchOutside(false);
    }

    void loaddata() {
        mess = "";
        BasicService.getInstance().SongOwner = readFile();

        listowner = BasicService.getInstance().SongOwner;

        listrequest = BasicService.getInstance().SongRequest;

        SongOwnedAdapter = new SongOwnedAdapter(MainActivity.this, MainActivity.this, listowner);
        listsongowned.setAdapter(SongOwnedAdapter);

        SongRequestAdapter = new SongRequestAdapter(MainActivity.this, MainActivity.this, listrequest);
        listsongrequest.setAdapter(SongRequestAdapter);
    }

    ArrayList<SongItem> readFile() {
        String pathToFile = Environment.getExternalStorageDirectory() + "/KTV_SYS/SONGLIST.txt";
        File file = new File(pathToFile);
        ArrayList<SongItem> songlist = new ArrayList<>();
        try {
            InputStreamReader inputStreamReader = new InputStreamReader(new FileInputStream(file), "UTF-16");
            BufferedReader br = new BufferedReader(inputStreamReader);
            String line;

            while ((line = br.readLine()) != null) {
                if (!line.equals("")) {
                    String[] arrayLine = line.split("[;]", -1);
                    SongItem song = assignString(arrayLine);
                    if (song != null) {
                        songlist.add(song);
                    }
                }
            }
            br.close();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return songlist;
    }


    void uploadFile() {
        UserInfo user = BasicService.getInstance().LoadAcc(MainActivity.this);
        final String uploadFilePath = Environment.getExternalStorageDirectory() + "/KTV_SYS/";
        final String uploadFileName = "SONGLIST.txt";
        File folder = new File(uploadFilePath);
        boolean success = true;
        if (!folder.exists()) {
            success = folder.mkdir();
        }
        if (success) {
            File file = new File(uploadFilePath + "" + uploadFileName);
            if (file.exists()) {
                UploadService.uploadFile(uploadFilePath + "" + uploadFileName, user, new UploadService.UploadCallBack() {
                    @Override
                    public void successCallBack(String result) {
                        mess = result;
                        //loaddata();
                    }

                    @Override
                    public void failCallBack(String error) {
                        mess = error;
                    }
                });
            } else {

            }
        } else {
            // Do something else on failure
        }
    }

    void writeFile(Song song) {
        try {
            checkFolder();
            checkFile();

            String pathToFile = Environment.getExternalStorageDirectory() + "/KTV_SYS/SONGLIST.txt";
            File file = new File(pathToFile);
            FileOutputStream fos = new FileOutputStream(file, true);
            OutputStreamWriter outputStreamWriter = new OutputStreamWriter(fos, "UTF-16");
            String fileName = BasicService.getInstance().CurrentSong.getName();
            int i = fileName.lastIndexOf('.');
            SongItem songItem = new SongItem(song, fileName.substring(i + 1));
            String textToWrite = getTextFromSong(songItem);
            outputStreamWriter.write(textToWrite);
            outputStreamWriter.close();
        } catch (Exception e) {
            Log.e("Exception", "File write failed: " + e.toString());
        }
    }

    SongItem assignString(String[] list) {
        SongItem song = new SongItem();
        song.setSongName(list[0]);
        song.setPosition(list[1]);
        song.setSinger(list[2]);
        song.setCountword(list[3]);
        song.setSonglang(list[4]);
        song.setVolumn(list[5]);
        song.setSpelling_song(list[6]);
        song.setSongID(list[7]);
        song.setSpelling_singer(list[8]);
        song.setSinger_class(list[9]);
        song.setSong_type_code(list[10]);
        song.setAlbum_name(list[11]);
        song.setSpelling_album(list[12]);
        song.setSinger_photo(list[13]);
        song.setSong_lyric(list[14]);
        song.setfiletype(list[15]);

        if (song.getSongID().substring(0, 2).equalsIgnoreCase("90")) {
            return song;
        } else {
            return null;
        }
    }

    String getTextFromSong(SongItem song) {
        String name = song.getSongName();
        String pos = song.getPosition();
        String singername = song.getSinger();
        String w_count = song.getCountword();
        String lang = song.getSonglang();
        String volume = song.getVolumn();
        String song_spell = song.getSpelling_song();
        String song_num = "90" + Utils.getFileName();
        String singer_spell = song.getSpelling_singer();
        String singer_class = song.getSinger_class();
        String song_type = song.getSong_type_code();
        String album_name = song.getAlbum_name();
        String album_spell = song.getSpelling_album();
        String singer_photo = song.getSinger_photo();
        String song_lyric = song.getSong_lyric();
        String filetype = song.getfiletype();

        String result = String.format("%s;%s;%s;%s;%s;%s;%s;%s;%s;%s;%s;%s;%s;%s;%s;%s",
                name,
                pos,
                singername,
                w_count,
                lang,
                volume,
                song_spell,
                song_num,
                singer_spell,
                singer_class,
                song_type,
                album_name,
                album_spell,
                singer_photo,
                song_lyric,
                filetype);

        return result + "\n";
    }

    void checkFolder() {
        String pathToFile = Environment.getExternalStorageDirectory() + "/KTV_SYS";
        File file = new File(pathToFile);
        if (!file.exists()) {
            file.mkdir();
        }
    }

    void checkFile() {
        String uploadFileName = "SONGLIST.txt";
        String pathToFile = Environment.getExternalStorageDirectory() + "/KTV_SYS/" + uploadFileName;
        File file = new File(pathToFile);
        if (!file.exists()) {
            try {
                file.createNewFile();
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
    }

    private interface onDownloadCompletedCallback {
        void onSuccess();
    }

    void DownloadCompleted(int id, UserInfo user, final Song song, final onDownloadCompletedCallback callback) {
        RestApiService.DownloadComplete(id, user, new RestApiCallBack() {
            @Override
            public void onSuccess(Boolean success, String response, Object object) {
                writeFile(song);
                callback.onSuccess();
            }

            @Override
            public void onFail(Boolean success, String error) {

            }
        });
    }

    @Override
    public void onBackPressed() {
        DialogInterface.OnClickListener dialogClickListener = new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                switch (which) {
                    case DialogInterface.BUTTON_POSITIVE:
                        MainActivity.super.onBackPressed();
                        break;

                    case DialogInterface.BUTTON_NEGATIVE:
                        break;
                }
            }
        };

        AlertDialog.Builder builder = new AlertDialog.Builder(MainActivity.this);
        builder.setMessage("Are you sure?").setPositiveButton("Yes", dialogClickListener)
                .setNegativeButton("No", dialogClickListener).show();

    }

}//End Activity class
