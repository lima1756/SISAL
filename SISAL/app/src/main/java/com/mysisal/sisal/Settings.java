package com.mysisal.sisal;

/**
 * Created by Luis Iván Morett on 16/05/2017.
 */

class Settings {
    private static final Settings ourInstance = new Settings();

    static Settings getInstance() {
        return ourInstance;
    }
    private int titleSize;
    private int textSize;
    private int barTextSize;
    private int menuOptionsTextSize;
    private int menuTitleTextSize;

    private Settings() {
        titleSize=30;
        titleSize=20;
    }

    public int getTitleSize() {
        return titleSize;
    }

    public void setTitleSize(int titleSize) {
        this.titleSize = titleSize;
    }

    public int getTextSize() {
        return textSize;
    }

    public void setTextSize(int textSize) {
        this.textSize = textSize;
    }

    public int getBarTextSize() {
        return barTextSize;
    }

    public void setBarTextSize(int barTextSize) {
        this.barTextSize = barTextSize;
    }

    public int getMenuOptionsTextSize() {
        return menuOptionsTextSize;
    }

    public void setMenuOptionsTextSize(int menuOptionsTextSize) {
        this.menuOptionsTextSize = menuOptionsTextSize;
    }

    public int getMenuTitleTextSize() {
        return menuTitleTextSize;
    }

    public void setMenuTitleTextSize(int menuTitleTextSize) {
        this.menuTitleTextSize = menuTitleTextSize;
    }
}
