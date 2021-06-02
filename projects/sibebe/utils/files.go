package utils

import (
	"io/ioutil"
	"log"
	"os"
)

func FileExists(file string) bool {
	currentLoggerOutput := log.Writer()
	log.SetOutput(ioutil.Discard)

	info, err := os.Stat(file)
	if os.IsNotExist(err) {
		return false
	}

	log.SetOutput(currentLoggerOutput)

	return !info.IsDir()
}

func DirExists(dir string) bool {
	currentLoggerOutput := log.Writer()
	log.SetOutput(ioutil.Discard)

	info, err := os.Stat(dir)
	if os.IsNotExist(err) {
		return false
	}

	log.SetOutput(currentLoggerOutput)

	return info.IsDir()
}

