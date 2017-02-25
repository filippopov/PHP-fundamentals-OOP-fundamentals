<?php

class InvalidSongException extends Exception
{

}

class InvalidArtistNameException extends InvalidSongException
{

}

class InvalidSongNameException extends InvalidSongException
{

}

class InvalidSongLengthException extends InvalidSongException
{

}

class InvalidSongMinutesException extends InvalidSongLengthException
{

}

class InvalidSongSecondsException extends InvalidSongLengthException
{

}

class Song
{
    private $artistName;

    private $songName;

    private $minutesAndSeconds;

    public function __construct($artistName, $songName, $minutesAndSeconds)
    {
        $this->setArtistName($artistName);
        $this->setSongName($songName);
        $this->setMinutesAndSeconds($minutesAndSeconds);
    }

    public function getArtistName()
    {
        return $this->artistName;
    }

    public function setArtistName($artistName)
    {
        if (strlen($artistName) < 3 || strlen($artistName) > 20) {
            throw new InvalidArtistNameException("Artist name should be between 3 and 20 symbols.");
        }
        $this->artistName = $artistName;
    }

    public function getSongName()
    {
        return $this->songName;
    }

    public function setSongName($songName)
    {
        if (strlen($songName) < 3 || strlen($songName) > 30) {
            throw new InvalidSongNameException("Song name should be between 3 and 30 symbols.");
        }
        $this->songName = $songName;
    }

    public function getMinutesAndSeconds()
    {
        return $this->minutesAndSeconds;
    }

    public function setMinutesAndSeconds($minutesAndSeconds)
    {
        $minutesAndSecondsArray = explode(':', $minutesAndSeconds);

        if (count($minutesAndSecondsArray) != 2) {
            throw new InvalidSongLengthException("Invalid song length.");
        }

        $minutes = $minutesAndSecondsArray[0];
        $seconds = $minutesAndSecondsArray[1];

        if ($minutes < 0 || $minutes > 14) {
            throw new InvalidSongMinutesException("Song minutes should be between 0 and 14.");
        }

        if ($seconds < 0 || $seconds > 59) {
            throw new InvalidSongSecondsException("Song seconds should be between 0 and 59.");
        }

        $this->minutesAndSeconds = $minutesAndSeconds;
    }
}

class SongDataBase
{
    /** @var Song[] $songsData*/
    private $songsData = [];

    public function setSongsData(Song $song)
    {
        $this->songsData[] = $song;
    }

    public function __toString()
    {
        $countSongs = count($this->songsData);
        $times = [];
        foreach ($this->songsData as $songData) {
            $times[] = $songData->getMinutesAndSeconds();
        }

        $time = $this->AddPlayTime($times);

        $songData = "Songs added: {$countSongs}" . PHP_EOL;
        $songData .= "Playlist length: {$time}";

        return $songData;
    }

    private function AddPlayTime($times) {
        $sec = 0;

        foreach ($times as $time) {
            list($minutes, $seconds) = explode(':', $time);
            $sec += $minutes * 60;
            $sec += $seconds;
        }

        $hours = intval($sec / (60 * 60));
        $sec -= intval($hours * 60 * 60);
        $seconds = $sec % 60;
        $sec -= $seconds;
        $minutes = $sec / 60;

        if ($minutes < 10) {
            $minutes = '0' . $minutes;
        }

        if ($seconds < 10) {
            $seconds = '0' . $seconds;
        }

        return "{$hours}h {$minutes}m {$seconds}s";
    }
}


$countOfSongs = (int) fgets(STDIN);
$songData = new SongDataBase();
while ($countOfSongs--) {
    $song = trim(fgets(STDIN));
    $songArray = explode(';', $song);

    $artistName = $songArray[0];
    $songName = $songArray[1];
    $minutesAndSeconds = $songArray[2];

    try {
        $songClass = new Song($artistName, $songName, $minutesAndSeconds);
        echo "Song added." . PHP_EOL;
        $songData->setSongsData($songClass);
    } catch (InvalidArtistNameException $e) {
        echo $e->getMessage() . PHP_EOL;
    } catch (InvalidSongNameException $e) {
        echo $e->getMessage() . PHP_EOL;
    } catch (InvalidSongMinutesException $e) {
        echo $e->getMessage() . PHP_EOL;
    } catch (InvalidSongSecondsException $e) {
        echo $e->getMessage() . PHP_EOL;
    } catch (InvalidSongLengthException $e) {
        echo $e->getMessage() . PHP_EOL;
    }
}

echo $songData;