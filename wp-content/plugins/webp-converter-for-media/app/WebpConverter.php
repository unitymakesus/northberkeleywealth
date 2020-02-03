<?php

  namespace WebpConverter;

  class WebpConverter
  {
    public function __construct()
    {
      new Admin\_Core();
      new Media\_Core();
      new Regenerate\_Core();
      new Settings\_Core();
    }
  }