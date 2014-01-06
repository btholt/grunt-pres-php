<?php
require dirname(__FILE__) . '/../app.php';

class AppTest extends PHPUnit_Framework_TestCase
{
	public static function setUpBeforeClass() {
		$client = new Predis\Client();
		$client->set('testing', null);
	}

	public function testCreateNotes() {
		$testCases = array(
			array(
				'text' => 'Test Case 1',
				'id' => 1
			),
			array(
				'text' => 'Test Case 2',
				'id' => 2
			),
			array(
				'text' => 'Test Case 3',
				'id' => 3
			)
		);
		for ($i = 0; $i < count($testCases); $i++) {
			$case = $testCases[$i];
			$response = createNote($case['text'], 'testing');
			$this->assertEquals($case['text'], $response['text']);
			$this->assertEquals($case['id'], $response['id']);
			$this->assertArrayHasKey('time', $response);
		}
		return $testCases;
	}

	/**
     * @depends testCreateNotes
     */
	public function testGetNotes($testCases) {
		$notesResponse = getNotes('testing');
		$notes = $notesResponse['notes'];
		for ($i = 0; $i < count($notes); $i++) {
			$note = $notes[$i];
			$case = $testCases[$i];
			$this->assertEquals($case['text'], $note['text']);
			// $this->assertEquals($case['id'], $note['id']);
			$this->assertArrayHasKey('time', $note);
		}

	}

	public static function tearDownAfterClass() {
		$client = new Predis\Client();
		$client->set('testing', null);
	}

}