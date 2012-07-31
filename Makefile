#!/usr/bin/make -f

test-unit-guard:
	guard

test-unit:
	phpunit --colors test/unit/*

test-acceptance:
	# casperjs test/acceptance/*
	pwd
	ls -la /home/vagrant/builds
	ls -la /home/vagrant/builds/proxmitybbdo

test: test-unit test-acceptance

.PHONY: test
