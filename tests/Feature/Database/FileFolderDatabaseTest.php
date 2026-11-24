<?php

namespace Tests\Feature\Database;

use App\Models\File;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FileFolderDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_folder(): void
    {
        $user = User::factory()->create();

        $folder = Folder::create([
            'user_id' => $user->id,
            'parent_id' => null,
            'name' => 'Dokumen Akademik',
        ]);

        $this->assertDatabaseHas('folders', [
            'id' => $folder->id,
            'user_id' => $user->id,
            'name' => 'Dokumen Akademik',
        ]);
        $this->assertNull($folder->parent_id);
    }

    public function test_folder_can_have_parent_and_children(): void
    {
        $user = User::factory()->create();

        $parent = Folder::create([
            'user_id' => $user->id,
            'parent_id' => null,
            'name' => 'Folder Induk',
        ]);

        $child = Folder::create([
            'user_id' => $user->id,
            'parent_id' => $parent->id,
            'name' => 'Folder Anak',
        ]);

        $this->assertEquals($parent->id, $child->parent_id);
        $this->assertTrue($parent->fresh()->children->contains($child->id));
        $this->assertEquals($parent->id, $child->fresh()->parent->id);
    }

    public function test_folder_root_has_null_parent_id(): void
    {
        $user = User::factory()->create();

        $root = Folder::create([
            'user_id' => $user->id,
            'parent_id' => null,
            'name' => 'Root Folder',
        ]);

        $this->assertNull($root->parent_id);
        $this->assertTrue($root->isRoot());
    }

    public function test_user_can_create_file(): void
    {
        $user = User::factory()->create();

        $file = File::create([
            'user_id' => $user->id,
            'folder_id' => null,
            'name' => 'tugas.pdf',
            'original_name' => 'tugas.pdf',
            'storage_path' => 'users/1/files/tugas.pdf',
            'mime_type' => 'application/pdf',
            'size' => 342000,
        ]);

        $this->assertDatabaseHas('files', [
            'id' => $file->id,
            'user_id' => $user->id,
            'name' => 'tugas.pdf',
        ]);
        $this->assertNull($file->folder_id);
        $this->assertSame(342000, $file->size);
    }

    public function test_user_has_many_files(): void
    {
        $user = User::factory()->create();

        File::create([
            'user_id' => $user->id,
            'folder_id' => null,
            'name' => 'file1.pdf',
            'original_name' => 'file1.pdf',
            'storage_path' => null,
            'mime_type' => 'application/pdf',
            'size' => 100,
        ]);
        File::create([
            'user_id' => $user->id,
            'folder_id' => null,
            'name' => 'file2.pdf',
            'original_name' => 'file2.pdf',
            'storage_path' => null,
            'mime_type' => 'application/pdf',
            'size' => 200,
        ]);
        File::create([
            'user_id' => $user->id,
            'folder_id' => null,
            'name' => 'file3.pdf',
            'original_name' => 'file3.pdf',
            'storage_path' => null,
            'mime_type' => 'application/pdf',
            'size' => 300,
        ]);

        $this->assertCount(3, $user->fresh()->files);
    }

    public function test_user_has_many_folders(): void
    {
        $user = User::factory()->create();

        Folder::create([
            'user_id' => $user->id,
            'parent_id' => null,
            'name' => 'Folder 1',
        ]);
        Folder::create([
            'user_id' => $user->id,
            'parent_id' => null,
            'name' => 'Folder 2',
        ]);

        $this->assertCount(2, $user->fresh()->folders);
    }

    public function test_file_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $file = File::create([
            'user_id' => $user->id,
            'folder_id' => null,
            'name' => 'file.pdf',
            'original_name' => 'file.pdf',
            'storage_path' => null,
            'mime_type' => 'application/pdf',
            'size' => 100,
        ]);

        $this->assertEquals($user->id, $file->fresh()->user->id);
    }

    public function test_folder_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $folder = Folder::create([
            'user_id' => $user->id,
            'parent_id' => null,
            'name' => 'Folder',
        ]);

        $this->assertEquals($user->id, $folder->fresh()->user->id);
    }

    public function test_folder_can_contain_files(): void
    {
        $user = User::factory()->create();
        $folder = Folder::create([
            'user_id' => $user->id,
            'parent_id' => null,
            'name' => 'Folder',
        ]);

        File::create([
            'user_id' => $user->id,
            'folder_id' => $folder->id,
            'name' => 'file1.pdf',
            'original_name' => 'file1.pdf',
            'storage_path' => null,
            'mime_type' => 'application/pdf',
            'size' => 100,
        ]);
        File::create([
            'user_id' => $user->id,
            'folder_id' => $folder->id,
            'name' => 'file2.pdf',
            'original_name' => 'file2.pdf',
            'storage_path' => null,
            'mime_type' => 'application/pdf',
            'size' => 200,
        ]);

        $this->assertCount(2, $folder->fresh()->files);
        $this->assertTrue($folder->fresh()->files->first()->folder->is($folder));
    }

    public function test_cannot_create_file_without_user(): void
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        File::create([
            'user_id' => 99999,
            'folder_id' => null,
            'name' => 'orphan.pdf',
            'original_name' => 'orphan.pdf',
            'storage_path' => null,
            'mime_type' => 'application/pdf',
            'size' => 100,
        ]);
    }

    public function test_cannot_create_folder_without_user(): void
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Folder::create([
            'user_id' => 99999,
            'parent_id' => null,
            'name' => 'Orphan Folder',
        ]);
    }
}
