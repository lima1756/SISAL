package com.mysisal.sisal;

import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.app.Service;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.os.IBinder;
import android.support.v4.app.NotificationCompat;
import android.util.Log;

import junit.framework.Test;

public class notifications extends BroadcastReceiver {


    public notifications() {
    }



    @Override
    public void onReceive(Context context, Intent intent)
    {
        String Title = intent.getStringExtra("Title");
        String Content = intent.getStringExtra("Content");
        String id;
        try {
            id = intent.getStringExtra("id");
        } catch (NullPointerException e) {id="";}

        Intent out = null;
        if(id.equals(""))
        {
            out = new Intent(context, patientStartActivity.class);
        }else
        {
            out = new Intent(context, pinActivity.class);
            out.putExtra("id", id);
        }
        long[] pattern = {0, 300, 0};
        PendingIntent pi = PendingIntent.getActivity(context, 01234, out, 0);
        NotificationCompat.Builder mBuilder = new NotificationCompat.Builder(context)
                .setSmallIcon(R.drawable.ic_logo)
                .setContentTitle(Title)
                .setContentText(Content)
                .setVibrate(pattern)
                .setAutoCancel(true);

        mBuilder.setContentIntent(pi);
        mBuilder.setDefaults(Notification.DEFAULT_SOUND);
        mBuilder.setAutoCancel(true);
        NotificationManager mNotificationManager = (NotificationManager) context.getSystemService(Context.NOTIFICATION_SERVICE);
        mNotificationManager.notify((int) System.currentTimeMillis(), mBuilder.build());
    }

}
