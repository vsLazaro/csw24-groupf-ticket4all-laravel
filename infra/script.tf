terraform {
    required_providers {
        aws = "~> 5.0"
    }
}

# Configure the AWS Provider
provider "aws" {
    region = "us-east-1"
}

resource "aws_instance" "instance_ec2" {
    ami           = "ami-0866a3c8686eaeeba"
    instance_type = "t2.micro"
    key_name = aws_key_pair.my_key_pair.key_name

    vpc_security_group_ids = [aws_security_group.api_access.id]

    tags = {
      Name = "instance-ec2"
    }

    user_data = <<-EOF
        #!/bin/bash
        set -e  # Terminate script if any command fails
        sudo apt-get update -y
        curl -fsSL https://get.docker.com -o get-docker.sh
        sudo sh get-docker.sh
        sudo usermod -aG docker ubuntu
        sudo systemctl enable docker
        sudo systemctl start docker
        echo "Docker installation completed" > /home/ubuntu/docker_installation.log
    EOF

}

resource "tls_private_key" "key_aws" {
    algorithm = "RSA"
    rsa_bits  = 4096
}

resource "aws_key_pair" "my_key_pair" {
    key_name   = "my-ec2-key"
    public_key = tls_private_key.key_aws.public_key_openssh
}

output "private_key_pem" {
    value     = tls_private_key.key_aws.private_key_pem
    sensitive = true
}

resource "aws_security_group" "api_access" {
  name        = "API-security-group-T1"
  description = "Security group para permitir SSH, HTTP e HTTPS"

  ingress {
    description = "SSH"
    from_port   = 22
    to_port     = 22
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    description = "HTTP"
    from_port   = 8080
    to_port     = 8080
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    description = "laravel port"
    from_port   = 3000
    to_port     = 3000
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }
}
